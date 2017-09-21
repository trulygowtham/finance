<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MYController;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;
use App\Model\NotificationsReceiver;
use App\Model\api\UserForm;
use App\Model\api\UserFormAnswers;
use DB;
use App\Users;

class ReportsController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $sessionInfo = Session::all();
        $created_by = $sessionInfo['user'][0]['id'];
        $data = array();
        $content_page = 'reports/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function userforms(Request $request) {
        $post_data = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);



        $user_id = $data['user_id'] = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
        $from_date = $data['from_date'] = isset($post_data['from_date']) ? $post_data['from_date'] : '';
        $to_date = $data['to_date'] = isset($post_data['to_date']) ? $post_data['to_date'] : '';
        $data['forms'] = UserForm::getCompletedUserForms($user_id, $from_date, $to_date);
        $content_page = 'reports/userforms'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function userFormCount(Request $request) {
        $post_data = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);

        $user_id = $data['user_id'] = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
        $from_date = $data['from_date'] = isset($post_data['from_date']) ? $post_data['from_date'] : '';
        $to_date = $data['to_date'] = isset($post_data['to_date']) ? $post_data['to_date'] : '';

        $data['forms'] = UserForm::getUserFormsCount($user_id, $from_date, $to_date);
        $content_page = 'reports/userFormCount'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function questionExpectedReport(Request $request) {
        
        $post_data = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);

        $user_id = $data['user_id'] = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
        $from_date = $data['from_date'] = isset($post_data['from_date']) ? $post_data['from_date'] : '';
        $to_date = $data['to_date'] = isset($post_data['to_date']) ? $post_data['to_date'] : '';
        
        //total expected
        $total_expected_arr = UserFormAnswers::getQuestionsExpectedCount($user_id, $from_date, $to_date);
        $ansArr = array();
        foreach ($total_expected_arr as $expArr) {
            $question_id = $expArr->question_id;
            $expected_arr = UserFormAnswers::getExpectedAnswerCount(array($expArr->id));
            $ansArr[$question_id][] = array('id' => $expArr->id, 'exp_cnt' => count($expected_arr), 'question_name' => $expArr->question_name);
        }
        $totResult = array();

        foreach ($ansArr as $question_id => $ansRow) {

            $total_qstns = count($ansRow);
            $question_name = '';
            $expAnsCnt = 0;
            foreach ($ansRow as $anskey => $ansValue) {
                $question_name = $ansValue['question_name'];
                if ($ansValue['exp_cnt']) {
                    $expAnsCnt++;
                }
            }
            $totResult[$question_id] = (object) array('question_name' => $question_name, 'total_cnt' => $total_qstns, 'exp_cnt' => $expAnsCnt);
        }

        $data['result'] = $totResult;
        $content_page = 'reports/questionExpectedReport'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function categoryExpectedReport(Request $request) {
        $post_data = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);

        $user_id = $data['user_id'] = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
        $from_date = $data['from_date'] = isset($post_data['from_date']) ? $post_data['from_date'] : '';
        $to_date = $data['to_date'] = isset($post_data['to_date']) ? $post_data['to_date'] : '';
        
        //total expected
        $total_expected_arr = UserFormAnswers::getCategoriesExpectedCount($user_id, $from_date, $to_date);
        $ansArr = array();
        foreach ($total_expected_arr as $expArr) {
            $cat_id = $expArr->cat_id;
            $expected_arr = UserFormAnswers::getExpectedAnswerCount(array($expArr->id));
            $ansArr[$cat_id][] = array('id' => $expArr->id, 'exp_cnt' => count($expected_arr), 'cat_name' => $expArr->cat_name);
        }
        $totResult = array();

        foreach ($ansArr as $question_id => $ansRow) {

            $total_qstns = count($ansRow);
            $question_name = '';
            $expAnsCnt = 0;
            foreach ($ansRow as $anskey => $ansValue) {
                $cat_name = $ansValue['cat_name'];
                if ($ansValue['exp_cnt']) {
                    $expAnsCnt++;
                }
            }
            $totResult[$question_id] = (object) array('cat_name' => $cat_name, 'total_cnt' => $total_qstns, 'exp_cnt' => $expAnsCnt);
        }

        $data['result'] = $totResult;
        $content_page = 'reports/categoryExpectedReport'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

}
