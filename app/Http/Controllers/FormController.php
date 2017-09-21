<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MYController;
use App\Http\Requests;
use App\Http\Requests\FormPostRequest;
use App\Model\Form;
use App\Model\Category;
use App\Model\Auditlogs;
use App\Model\Questions;
use App\Model\Group;
use App\Users;
use App\Model\LinkFormGroups;
use App\Model\LinkFormUsers;

use App\Model\LinkUserGroups;

use App\Model\Notifications;
use App\Model\NotificationsReceiver;
use Auth;
use DB;
use Session;
use View;
use App\Model\api\UserForm;
//For Datatables
use yajra\Datatables\Datatables;

//qrcode generation
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use File;
use \Crypt;

class FormController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $session_data = Session::all();
        $login_id = $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $admin_id = $session_data['admin_id']; 
        $data['forms'] = Form::getTotalTemplates();
        $content_page = 'forms/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function getData() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id']; 
        return Datatables::of(Form::where(array('record_status'=>1))->whereIn('created_by',array($admin_id,$created_by))->orderBy('created_at', 'asc')->get())
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            if ($query->status == 2) {
                                $buttons.='<a href="' . route("form.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            } else {
                                $buttons.='<a title="Add users" href="" onclick="show_users(' . $query->id . ',' . "'" . $query->name . "'" . ')"  data-toggle="modal" data-target="#myUserModal" ><div class="pull-right btn btnIcon bgBlue btnAssignU"> &nbsp; </div></a>';
                                $buttons.='<a title="Add groups" href="" onclick="show_groups(' . $query->id . ',' . "'" . $query->name . "'" . ')"  data-toggle="modal" data-target="#myModal" ><div class="pull-right btn btnIcon bgGreen btnAssignG"> &nbsp; </div></a>';
                            }

                            $buttons.=' <a href="' . route("form.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';

                            if ($query->status == 2) {
                                $buttons.='<a href="' . route("form.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this form?'" . ')" >';
                                $buttons.='<div class="pull-right btn btnIcon bgRed btnCancel mrzR5"> &nbsp; </div>  </a>';
                            }
                            $buttons.='</div>';
                            return $buttons;
                        })->make(true);
    }
    public function getUserForms(Request $request) {
        $post_data = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        
        
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] =  Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);
        
        
        
        $user_id = $data['user_id'] = isset($post_data['user_id'])?$post_data['user_id']:0;
        $from_date = $data['from_date'] = isset($post_data['from_date'])?$post_data['from_date']:'';
        $to_date = $data['to_date'] = isset($post_data['to_date'])?$post_data['to_date']:'';
        
        $data['forms'] = UserForm::getUserForms($user_id,$from_date,$to_date);
        
        
        $content_page = 'forms/userform'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function getUserFormData() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        return Datatables::of(UserForm::getUserForms($created_by))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>"; 
                            $buttons.=' <a href="' . route("form.userFormView", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
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
        $data['category'] = Category::where(array('record_status'=>1))->whereIn('created_by',array($created_by,$id))->orderBy('name', 'asc')->get();
        $content_page = 'forms/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(FormPostRequest $request) {
        $inputArr = array();
        $postArr = $request->all();
        $inputArr['_token'] = $postArr['_token'];
        $inputArr['name'] = $postArr['name'];
        $inputArr['no_of_questions'] = array_sum(array_map('count', $postArr['question']));
        $questions = array();

        foreach ($postArr['category'] as $iKey => $iVal) {
            $questions[$iVal] = $postArr['question'][$iKey];
        }
        $inputArr['questions'] = serialize($questions);
        $inputArr['description'] = $postArr['description'];

        $inputArr['status'] = $postArr['status'];

        $session_data = Session::all();
        $inputArr['created_by'] = $session_data['user'][0]['id'];
        $inputArr['admin_id'] = $session_data['admin_id'];
        
        
        
        $page = Form::create($inputArr);
        $frmName = $inputArr['name'];
        if ($page != '') {
            
            //qrcode generation 
            $qrcode = new BaconQrCodeGenerator;
            if(!file_exists(public_path('qrcodes'))){
                File::makeDirectory(public_path('qrcodes'),0777);
            } 
            $form_id = $page->id;
            $acckey = Crypt::encrypt($form_id);
            $userImg = "$form_id.png";
            $qrcode->format('png')->size(399)->generate("$acckey",public_path('qrcodes').'/'.$userImg); 
            $ticket_id = 'TEMP' . str_pad($form_id, 5, '0', STR_PAD_LEFT);
            $updateInfo = array('qr_image'=>$userImg,'template_id'=>$ticket_id);
            $isUpdated = Form::where('id', $form_id)->update($updateInfo);
            //end qr code generation
            
            //category tab type  auditlogs added
            $message = "Form #$frmName  created successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '5');
        }
        return redirect()->route('form')->with('success-status', "Form #$frmName  created successfully!");
    }

    public function edit($id) {
        $form_data = Form::whereId(base64_decode($id))->first();
        $form_data->questions = unserialize($form_data->questions);
        $question_arr = ($form_data->questions);

        $question_ids = array_unique(call_user_func_array('array_merge', $question_arr));
        $question = Questions::getQuestionsByIds($question_ids);
        $data['questions'] = array();
        $data['category'] = array();
        foreach ($question as $iKey => $iVal) {
            $data['category'][$iVal->category_id] = $iVal->category_name;
            $data['questions'][$iVal->id] = array();
            $data['questions'][$iVal->id]['id'] = $iVal->id;
            $data['questions'][$iVal->id]['name'] = $iVal->name;
            $data['questions'][$iVal->id]['options'] = unserialize($iVal->options);
        }
        $data['form_data'] = $form_data;
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_by = $session_data['admin_id']; 
        $login_id = $session_data['user'][0]['id'];
        $data['category'] = Category::where(array('record_status'=>1))->whereIn('created_by',array($created_by,$login_id))->orderBy('name', 'asc')->get();
        $data['allQuestions'] = array();
        $allQuestionsArr = array();
        
        $allQuestions = Questions::getQuestions($login_id,$created_by);
        foreach ($allQuestions as $iKey => $iVal) {
            $allQuestionsArr[$iVal->category_id][] = $iVal;
        }
        $data['allQuestions'] = $allQuestionsArr;
        $content_page = 'forms/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(FormPostRequest $request, $id) {
        $postArr = $request->all();
        //$inputArr['_token'] = $postArr['_token'];
        $inputArr['name'] = $postArr['name'];
        $inputArr['no_of_questions'] = array_sum(array_map('count', $postArr['question']));
        $questions = array();
        foreach ($postArr['category'] as $iKey => $iVal) {
            $questions[$iVal] = $postArr['question'][$iKey];
        }

        $inputArr['questions'] = serialize($questions);
        $inputArr['description'] = $postArr['description'];
        $session_data = Session::all();
        $inputArr['created_by'] = $session_data['user'][0]['id'];
        $inputArr['status'] = $postArr['status'];
        $frmName = $inputArr['name'];
        //$inputs = $request->except('_token', '_method');
        $page = Form::where('id', base64_decode($id))->update($inputArr);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "Form #$frmName  updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '5');
        }
        return redirect()->route('form')->with('success-status', "Form #$frmName updated successfully!");
    }

    public function view($id) {
        $form_data = Form::whereId(base64_decode($id))->first();
        $form_data->questions = unserialize($form_data->questions);
        $question_arr = ($form_data->questions);

        $question_ids = array_unique(call_user_func_array('array_merge', $question_arr));
        $question = Questions::getQuestionsByIds($question_ids);
        $data['questions'] = array();
        $data['category'] = array();
        foreach ($question as $iKey => $iVal) {
            $data['category'][$iVal->category_id] = $iVal->category_name;
            $data['questions'][$iVal->id] = array();
            $data['questions'][$iVal->id]['name'] = $iVal->name;
            $data['questions'][$iVal->id]['options'] = unserialize($iVal->options);
        }
        $data['form_data'] = $form_data;
        $content_page = 'forms/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }
    public function userFormView($id) {
        $form_data = UserForm::getUserFormInfo(base64_decode($id));
        $form_data->form_info = unserialize($form_data->form_info); 
        $data['form_data'] = $form_data;
        $content_page = 'forms/userformview'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }
//
    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Form::where('id', base64_decode($id))->update($inputs);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "Form deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '5');
        }
        return redirect()->route('form')->with('success-status', 'Form deleted successfully!');
    }

    public function preview(Request $request) {
        $data = array();
        $inputArr = array();
        $postArr = $request->all();
        $questions = array();

        foreach ($postArr['category'] as $iKey => $iVal) {
            $questions[$iVal] = $postArr['question'][$iKey];
        }
        $question_ids = array_unique(call_user_func_array('array_merge', $questions));
        $question = Questions::getQuestionsByIds($question_ids);
        
        $data['questions'] = array();
        $data['category'] = array();
        foreach ($question as $iKey => $iVal) {
            $data['category'][$iVal->category_id] = $iVal->category_name;
            $data['questions'][$iVal->id] = array();
            $data['questions'][$iVal->id]['name'] = $iVal->name;
            $data['questions'][$iVal->id]['options'] = unserialize($iVal->options);
        }
       
        $form_data = (object) array();
        $form_data->questions = $questions;
        $data['form_data'] = $form_data;

        $content_page = 'forms/viewform'; // Middle page where content needs to be displayed
        echo View::make($content_page, $data)->render();
    }

    public function getCatInfo(Request $request) {
        $data = array();
        $inputArr = array();
        $postArr = $request->all(); 
        $sel_list = isset($postArr['sel_list'])?$postArr['sel_list']:array();
        $sel_val = isset($postArr['sel_val'])?$postArr['sel_val']:0;
        $category = Category::where('record_status', 1)->whereNotIn('id', $sel_list)->orderBy('name', 'asc')->get();
        $result = "<option value=''>Select</option>";
        foreach($category as $catRow){
            $selected = ($sel_val==$catRow->id)?'SELECTED':'';
            $result.= "<option value=".$catRow->id." $selected>".$catRow->name."</option>";
        } 
        echo $result;
    }

    public function groups(Request $request) {
        $data = array();
        $inputArr = array();
        $postArr = $request->all();
        $questions = array();
        $from_id = $postArr['form_id'];
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $groups = Group::getGroupList($created_by);
        $user_groups = LinkFormGroups::select('group_id')->where('form_id', $from_id)->select('group_id')->get();
        $group_arr = array();
        foreach ($user_groups as $group_row) {
            $group_arr[] = $group_row->group_id;
        }
        $group_size = (count($groups) > 4) ? count($groups) + 1 : 5;
        $result = '<select class="form-control select2-select-00" style="width: 100% !important;"  data-placeholder="Select a group" multiple id="group_id" name="group_id[]" size="' . $group_size . '">';
        $result.= '';
        foreach ($groups as $key => $groupRow) {
            $selected_val = in_array($groupRow['id'], $group_arr) ? 'SELECTED' : '';

            $result.= '<option value="' . $groupRow['id'] . '" ' . $selected_val . '>' . $groupRow['name'] . '</option>';
        }
        $result.= '</select>';
        echo $result;
    }
    public function users(Request $request) {
        $data = array();
        $inputArr = array();
        $postArr = $request->all();
        $questions = array();
        $from_id = $postArr['form_id'];
         $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $users = Users::getUserInfo($role_id=2,$created_by);
        $user_groups = LinkFormUsers::select('user_id')->where('form_id', $from_id)->select('user_id')->get();
        $group_arr = array();
        foreach ($user_groups as $group_row) {
            $group_arr[] = $group_row->user_id;
        }
        $group_size = (count($users) > 4) ? count($users) + 1 : 5;
        $result = '<select class="form-control select2-select-00" style="width: 100% !important;"  data-placeholder="Select a user" multiple id="user_id" name="user_id[]" size="' . $group_size . '">';
        $result.= '';
        foreach ($users as $key => $userRow) {
            $selected_val = in_array($userRow['id'], $group_arr) ? 'SELECTED' : '';

            $result.= '<option value="' . $userRow['id'] . '" ' . $selected_val . '>' . $userRow['name'].' '.$userRow['last_name'].'('.$userRow['username'].')' . '</option>';
        }
        $result.= '</select>';
        echo $result;
    }
    public function linkGroups(Request $request) {
        $postArr = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_name = $session_data['user'][0]['name'];
        //update user groups
        $created_at = date('Y-m-d H:i:s');
        $group_arr = $postArr['group_id'];
        $form_id = $postArr['form_id'];
        //get template name
        $form_data = Form::whereId($form_id)->first();
        $templateName = isset($form_data->name)?$form_data->name:'';
        if (count($group_arr) > 0) {
            LinkFormGroups::deleteFormGroups($form_id);
            //insert notifications 
            $link_arr = array('notification_type_id' => 1, 'notification_text' => "Template# $templateName has been assigned to your group",'notification_links'=>  $form_id, 'created_at' => $created_at, 'created_by' => $created_by,'created_name'=>$created_name);
            $notifications = Notifications::createNotifications($link_arr);
            $note_id = isset($notifications->id)?$notifications->id:0;
            $groupArr = array();
            foreach ($group_arr as $group_row) {
                if ($group_row != '') {
                    $insert_arr = array('form_id' => $form_id, 'group_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                    $isAdded = LinkFormGroups::createFormGroups($insert_arr);
                    if($isAdded){
                        $groupArr[]=$group_row;
                    }
                }
            }
             
            if($note_id>0 && count($groupArr)>0){
                $user_groups = LinkUserGroups::select('user_id')->whereIn('group_id',$groupArr)->groupBy('user_id')->get();
                foreach ($user_groups as $grpkey => $grpRow) {
                    $link_arr = array('receiver_id' => $grpRow->user_id, 'notification_id' => $note_id, 'created_at' => $created_at);
                    NotificationsReceiver::createNotificationsReceiver($link_arr);
                }

            }
             
            //category tab type  auditlogs added
            $message = "Groups have been added successfully to form!";
            Auditlogs::addAuditlogs($message, $tabtype = '5');
        }
        return redirect()->route('form')->with('success-status', 'Groups have been added successfully to form.');
    }
    public function linkUsers(Request $request) {
        $postArr = $request->all();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_name = $session_data['user'][0]['name'];
        //update user groups
        $created_at = date('Y-m-d H:i:s');
        $group_arr = $postArr['user_id'];
        $form_id = $postArr['user_form_id'];
        $form_data = Form::whereId($form_id)->first();
        $templateName = isset($form_data->name)?$form_data->name:'';
        if (count($group_arr) > 0) {
            LinkFormUsers::deleteFormUsers($form_id);
            $link_arr = array('notification_type_id' => 1, 'notification_text' => "Template# $templateName has been assigned to you",'notification_links'=>  $form_id, 'created_at' => $created_at, 'created_by' => $created_by,'created_name'=>$created_name);
            $notifications = Notifications::createNotifications($link_arr);
            $note_id = isset($notifications->id)?$notifications->id:0;
            foreach ($group_arr as $group_row) {
                if ($group_row != '') {
                    $insert_arr = array('form_id' => $form_id, 'user_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                    $isAdded = LinkFormUsers::createFormUsers($insert_arr);
                    if($isAdded){ 
                        if($note_id>0){ 
                            $link_arr = array('receiver_id' => $group_row, 'notification_id' => $note_id, 'created_at' => $created_at);
                            NotificationsReceiver::createNotificationsReceiver($link_arr);
                        }
                    }
                }
            }
            //category tab type  auditlogs added
            $message = "Users have been added successfully to form!";
            Auditlogs::addAuditlogs($message, $tabtype = '5');
        }
        return redirect()->route('form')->with('success-status', 'Users have been added successfully to form.');
    }

}
