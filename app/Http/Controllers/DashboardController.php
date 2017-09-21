<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MYController;
use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests;
use App\Users;
use App\Model\Auditlogs;
use App\Model\api\UserForm;
use App\Model\api\UserFormAnswers;
use App\Model\api\UserFormQuestions;
use App\Model\Form;
use App\Model\Group;
use App\Model\Category;
use Session;

class DashboardController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $data = array();
        $session_data = Session::all();
        $role_id = $session_data['user'][0]['role_id'];
        $admin_id = $session_data['admin_id'];
        $created_by = $session_data['user'][0]['id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        //today counts
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
        $data['today_completed'] = UserForm::getFormCount($from_date, $to_date, 2, $created_by);
        $data['today_pending'] = UserForm::getFormCount($from_date, $to_date, 1, $created_by);
        $data['today_cancel'] = UserForm::getFormCount($from_date, $to_date, 3, $created_by);
        
        //today expected
       
        $today_expected_arr = UserFormAnswers::getTotalExpectedCount($from_date,$to_date);
        $ansArr = array();
        foreach ($today_expected_arr as $expArr) {
            $ansArr[] = $expArr->id;
        }

        $expected_arr = UserFormAnswers::getExpectedAnswerCount($ansArr);
        $totalExp = 0;
        if (count($today_expected_arr) > 0 && count($expected_arr) > 0) {
            $totalExp = round((count($expected_arr) / count($today_expected_arr)) * 100, 2);
        }

        $data['today_expected_cnt'] = $totalExp;
        
        
        //weekly counts
        $from_date = date('Y-m-d', strtotime('-7 days'));
        $to_date = date('Y-m-d');
        $data['weekly_completed'] = UserForm::getFormCount($from_date, $to_date, 2, $created_by);
        $data['weekly_pending'] = UserForm::getFormCount($from_date, $to_date, 1, $created_by);
        $data['weekly_cancel'] = UserForm::getFormCount($from_date, $to_date, 3, $created_by);
        
        //weekly expected
        $total_expected_arr = UserFormAnswers::getTotalExpectedCount($from_date,$to_date);
        $ansArr = array();
        foreach ($total_expected_arr as $expArr) {
            $ansArr[] = $expArr->id;
        }
        $expected_arr = UserFormAnswers::getExpectedAnswerCount($ansArr);
        $totalExp = 0;
        if (count($total_expected_arr) > 0 && count($expected_arr) > 0) {
            $totalExp = round((count($expected_arr) / count($total_expected_arr)) * 100, 2);
        }
        $data['weekly_expected_cnt'] = $totalExp;
        
        //monthly counts
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-t');
        $data['montly_completed'] = UserForm::getFormCount($from_date, $to_date, 2, $created_by);
        $data['montly_pending'] = UserForm::getFormCount($from_date, $to_date, 1, $created_by);
        $data['montly_cancel'] = UserForm::getFormCount($from_date, $to_date, 3, $created_by);
        //montly expected
        $total_expected_arr = UserFormAnswers::getTotalExpectedCount($from_date,$to_date);
        $ansArr = array();
        foreach ($total_expected_arr as $expArr) {
            $ansArr[] = $expArr->id;
        }
        $expected_arr = UserFormAnswers::getExpectedAnswerCount($ansArr);
        $totalExp = 0;
        if (count($total_expected_arr) > 0 && count($expected_arr) > 0) {
            $totalExp = round((count($expected_arr) / count($total_expected_arr)) * 100, 2);
        }
        $data['monthly_expected_cnt'] = $totalExp;

        //Total counts
        $data['total_category'] = Category::getCatList($admin_id, $created_by);
        $data['total_templates'] = Form::getTotalTemplates();
        $data['total_departments'] = Group::getGroupList($created_by);
        $data['total_users'] = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);

        

         
        
        $content_page = 'dashboard/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('dashboard/index');
    }

    public function checkLogin(LoginPostRequest $request) {


        $request_data = $request->all();
        $users = Users::where(array('username' => $request_data['username'], 'password' => $request_data['password']))->first();
        if (!EMPTY($users) && count($users) > 0) {
            $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
            $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
            $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
            $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail);
            if ($userid > 0) {
                Session::push('user', $userInfo);
                return redirect()->route('users');
            } else {
                return redirect()->route('login')->with('error-status', "Username and password doesn't match");
            }
        } else {
            return redirect()->route('login')->with('error-status', "Username and password doesn't match");
        }
    }

    public function logout(Request $request) {
        //login tab type  auditlogs added
        $message = 'Logged-Out';
        Auditlogs::addAuditlogs($message, $tabtype = '1');
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect()->route('login')->send();
    }

}
