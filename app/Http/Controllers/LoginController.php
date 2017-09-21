<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\ForgotPasswordPostRequest;
use App\Http\Requests;
use App\Model\LinkUserGroups;
use App\Model\Auditlogs;
use App\Users;
use Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use View;

class LoginController extends Controller {

    public function __construct() {

        if (Session::has('user')) {
            Redirect::route('dashboard')->send();
        } else {
            
        }
    }

    public function index() {
        return view('auth/login');
    }

    public function checkLogin(LoginPostRequest $request) {

        $request_data = $request->all();
        $users = Users::where(array('username' => $request_data['username'], 'record_status' => 1, 'status' => 1))
                        ->whereIn('role_id', array(1, 3, 4))
                        ->where(function($query) use ($request_data) {
                            $query->where(array('password' => md5($request_data['password'])));
                            $query->orwhere(array('tmp_password' => md5($request_data['password'])));
                        })->first();
        if (!EMPTY($users) && count($users) > 0) {
            $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
            $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
            $username .= isset($users['attributes']['last_name']) ? ' ' . $users['attributes']['last_name'] : '';
            $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
            $usertitle = isset($users['attributes']['title']) ? $users['attributes']['title'] : '';
            $created_by = isset($users['attributes']['created_by']) ? $users['attributes']['created_by'] : 0;
            $profile_avatar = (isset($users['attributes']['profile_avatar']) && $users['attributes']['profile_avatar'] != '') ? url('public/images') . '/' . $users['attributes']['profile_avatar'] : '';
            $role_id = isset($users['attributes']['role_id']) ? $users['attributes']['role_id'] : 0;
            $user_groups = LinkUserGroups::select('group_id')->where('user_id', $userid)->get();
            $groupArr = array();
            if (!EMPTY($user_groups) && count($user_groups) > 0) {
                foreach ($user_groups as $groupRow) {
                    $groupArr[] = $groupRow->group_id;
                }
            }
            $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail, 'title' => $usertitle, 'profile_avatar' => $profile_avatar, 'created_by' => $created_by, 'role_id' => $role_id, 'group_arr' => $groupArr);
            if ($userid > 0) {

                Session::push('user', $userInfo);
                //login tab type  auditlogs added
                $message = 'Logged-In';
                Auditlogs::addAuditlogs($message, $tabtype = '1');

                return redirect()->route('dashboard');
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
        echo Session::has('user');
        die();
        // Redirect::route('login')->send();
    }

    public function forgotpassword(ForgotPasswordPostRequest $request) {
        $request_data = $request->all();
        $data['users'] = $users = Users::where(array('username' => $request_data['username'], 'record_status' => 1, 'status' => 1))->first();
        if (!EMPTY($users) && count($users) > 0) {
            $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
            $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
            $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
            $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail);
            if ($userid > 0) {

                $number = mt_rand(10000, 99999);
                $inputs = array();
                $inputs['tmp_password'] = md5($number);
                Users::where('id', $userid)->update($inputs);

                Mail::send('auth.emails.password', ['user' => $users], function ($m) use ($users, $number) {
                    $data['users'] = $users;
                    $data['password'] = $number;
                    $viewContent = View::make("users/mail_templates/forgot_password", $data)->render();
                    $m->from('v.phaneendrakumar@gmail.com', 'Checklist');
                    $m->setBody(nl2br($viewContent), 'text/html');
                    $m->to($users->email, $users->name)->subject('Forgot password notification email');
                });



                return redirect()->route('login')->with('success-status', "One time password was sent to your email.");
            } else {
                return redirect()->route('login')->with('error-status', "Username doesn't match");
            }
        } else {
            return redirect()->route('login')->with('error-status', "Username doesn't match");
        }
    }

}
