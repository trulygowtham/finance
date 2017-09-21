<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MYController;
use App\Http\Requests;
use App\Http\Requests\QuestionPostRequest;
use App\Model\Questions;
use App\Model\Category;
use App\Model\Auditlogs;
use Auth;
use DB;
use Session;
//For Datatables
use yajra\Datatables\Datatables;

class QuestionController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id']; 
        $id = $session_data['user'][0]['id']; 
        $data['users'] = $users = Questions::getQuestions($created_by,$admin_id);
        $content_page = 'questions/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('questions/index', compact('users'));
    }

    public function getData() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id']; 
        $id = $session_data['user'][0]['id']; 
        return Datatables::of(Questions::getQuestions($created_by,$admin_id))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            $buttons.='<a href="' . route("questions.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            $buttons.=' <a href="' . route("questions.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='<a href="' . route("questions.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this question?'" . ')" >';
                            $buttons.='<div class="pull-right btn btnIcon bgRed btnCancel mrzR5"> &nbsp; </div>  </a>';
                            $buttons.='</div>';
                            return $buttons;
                        })->make(true);
    }

    public function create() {
        $data = array();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_by = $session_data['admin_id']; 
        $id = $session_data['user'][0]['id']; 
        $data['category'] = Category::getCatList($created_by, $id);
        $content_page = 'questions/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(QuestionPostRequest $request) {

        $postArr = $request->all();
        $session_data = Session::all();
        //echo '<pre/>'; print_r($postArr);die();
        $success_cnt = 0;
        if (count($postArr['name'])) {
            foreach ($postArr['name'] as $qstnKey => $qstnName) {
                $inputArr = array();
                $que_options = array();
                $option_type = isset($postArr['option_type'][$qstnKey]) ? $postArr['option_type'][$qstnKey] : '';
                if ($qstnName != '' && $option_type!='') {
                    $inputArr['_token'] = $postArr['_token'];
                    $inputArr['category_id'] = $postArr['category_id'];
                    $inputArr['created_by'] = $session_data['user'][0]['id'];
                    $inputArr['admin_id'] = $session_data['admin_id'];
                    $inputArr['record_status'] = 1;
                    $inputArr['name'] = $qstnName;
                    $inputArr['description'] = isset($postArr['description'][$qstnKey]) ? $postArr['description'][$qstnKey] : '';
                    $que_options['option_type'] = isset($postArr['option_type'][$qstnKey]) ? $postArr['option_type'][$qstnKey] : '';
                    if (in_array($que_options['option_type'], array('input', 'textarea'))) {
                        $que_options['no_of_options'] = $postArr['no_of_options'][$qstnKey];
                        $que_options['options'] = array();
                        $que_options['mandatory'] = array();
                    } else {
                        $que_options['no_of_options'] = count($postArr['options'][$qstnKey]); 
                        $que_options['options'] = isset($postArr['options'][$qstnKey]) ? $postArr['options'][$qstnKey] : array();
                        $que_options['mandatory'] = isset($postArr['manhid'][$qstnKey]) ? $postArr['manhid'][$qstnKey] : array();
                    }
                    $inputArr['options'] = serialize($que_options);
                    $page = Questions::create($inputArr);
                    if($page){
                        $success_cnt++;
                    }
                }
            }
        }
        /* $inputArr['name'] = $postArr['name'];
          $inputArr['description'] = $postArr['description'];
          $que_options['option_type'] = $postArr['option_type'];
          if (in_array($que_options['option_type'], array('input', 'textarea'))) {
          $que_options['no_of_options'] = $postArr['no_of_options'];
          $que_options['options'] = array();
          } else {
          $que_options['no_of_options'] = count($postArr['options']);
          $que_options['options'] = ($postArr['options']);
          }
          $inputArr['options'] = serialize($que_options); */

        
        //$queName = $inputArr['name'];
        if ($success_cnt>0) {
            $categoryInfo = Category::where('id', $postArr['category_id'])->orderBy('name', 'asc')->get()->first();
            $catName = isset($categoryInfo->name)?$categoryInfo->name:'';
            //category tab type  auditlogs added
            $message = "Question Count $success_cnt have been successfully to $catName!";
            Auditlogs::addAuditlogs($message, $tabtype = '4');
            return redirect()->route('questions')->with('success-status', "Question Count $success_cnt have been successfully to $catName!");
        }else{
            return redirect()->route('questions.add')->with('error-status', "Please select questions");
        }
        
    }

    public function edit($id) {
         $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_by = $session_data['admin_id']; 
        $login_id = $session_data['user'][0]['id']; 
        $data['question'] = Questions::getQuestionsById(base64_decode($id));
        $data['question'][0]['options'] = unserialize($data['question'][0]['options']);
        $data['category'] = Category::getCatList($created_by, $login_id);
        $content_page = 'questions/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(QuestionPostRequest $request, $id) {
        //$inputs = $request->except('_token', '_method');

        $inputArr = array();
        $que_options = array();
        $postArr = $request->except('_token', '_method');
        //echo '<pre/>';print_r($postArr);die();
        //$inputArr['_token'] = $postArr['_token'];
        $inputArr['category_id'] = $postArr['category_id'];
        $inputArr['name'] = $postArr['name'];
        $inputArr['description'] = $postArr['description'];
        $que_options['option_type'] = $postArr['option_type'];
        if (in_array($que_options['option_type'], array('input', 'textarea'))) {
            $que_options['no_of_options'] = $postArr['no_of_options'];
            $que_options['options'] = array();
            $que_options['mandatory'] = array();
        } else {
            $que_options['no_of_options'] = count($postArr['options']);
            $que_options['options'] = ($postArr['options']);
            $que_options['mandatory'] = ($postArr['manhid']);
        }
        $inputArr['options'] = serialize($que_options);
        $session_data = Session::all();
        $inputArr['created_by'] = $session_data['user'][0]['id'];

        $page = Questions::where('id', base64_decode($id))->update($inputArr);
        $catName = $inputArr['name'];
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "Question #$catName updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '4');
        }
        return redirect()->route('questions')->with('success-status', "Question #$catName updated successfully!");
    }

    public function view($id) {
        $data['question'] = Questions::getQuestionsById(base64_decode($id));
        $data['question'][0]['options'] = unserialize($data['question'][0]['options']);
        $content_page = 'questions/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Questions::where('id', base64_decode($id))->update($inputs);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "Question deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '4');
        }
        return redirect()->route('questions')->with('success-status', 'Question deleted successfully!');
    }

    public function questions_list(Request $request) {
        if ($request->isMethod('post')) {
            $postArr = $request->except('_token', '_method');
            //$inputArr['_token'] = $postArr['_token'];
            $category_id = $postArr['category_id'];
            $question = Questions::getQuestionsByCategoryId($category_id);
            return response()->json($question);
        } else if ($request->isMethod('get')) {
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];
            $question = Questions::getQuestions($created_by);
            return response()->json($question);
        }
    }

}
