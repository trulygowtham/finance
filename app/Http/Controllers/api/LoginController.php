<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Http\Controllers\Controller;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use App\Http\Requests\LoginPostRequest; 
use App\Http\Requests;
use App\Model\Auditlogs;
use App\Model\api\Api;
use App\Users;
use Session; 
use DB;

class LoginController extends Controller {

    public function __construct() {

        /* if (Session::has('user')) { 
          Redirect::route('dashboard')->send();
          } else {

          } */
    }

    public function index() {
        //return view('auth/login');
    }

    public function checkLogin(Request $request) {
        Api::addApilogs($request);
        $validator = Validator::make($request->all(), [
                    'username' => 'required',
                    'password' => 'required',
        ]);
        if ($validator->fails()) {

            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {

            $result = array('error' => true, 'list' => array(), 'message' => "");

            $request_data = $request->all();
            $users = Users::where(array('username' => $request_data['username'], 'record_status' => 1, 'status' => 1))
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
                $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail, 'title' => $usertitle, 'profile_avatar' => $profile_avatar,'created_by'=>$created_by);
                if ($userid > 0) {
                    $accessToken = users::newAccessToken($userid,$request_data);
                    if (Session::has('user')) {
                        $request->session()->forget('user');
                    }
                    Session::push('user', $userInfo);
                    //login tab type  auditlogs added 
                    $message = 'Logged-In';
                    
                    Auditlogs::addAuditlogs($message, $tabtype = '1',$created_by);
                    $result = array('error' => false, 'api_token' => $accessToken, 'list' => $userInfo, 'message' => "User logged-in successfully.");
                } else {
                    $result = array('error' => true, 'list' => array(), 'message' => "Username and password doesn't match.");
                }
            } else {
                $result = array('error' => true, 'list' => array(), 'message' => "Username and password doesn't match.");
            }
        }
        return Response::json($result, 200);
    }

    public function logout(Request $request) {
        Api::addApilogs($request);
        //login tab type  auditlogs added
        if (Session::has('user')) {
            $data = $request->session()->all();
            $userid = $data['user'][0]['id'];
            $created_by = $data['user'][0]['created_by'];

            $accessToken = users::deleteAccessToken($userid);
            $message = 'Logged-Out';
            Auditlogs::addAuditlogs($message, $tabtype = '1',$created_by);
            $request->session()->forget('user');
            $request->session()->flush();
            $result = array('error' => false, 'message' => "User logged-out successfully.");
        } else {
            $result = array('error' => true, 'message' => "User logged-out failed.");
        }
        return Response::json($result, 200);
    }

    public function forgotpassword(Request $request) {
        Api::addApilogs($request);
        $validator = Validator::make($request->all(), [
                    'username' => 'required',
        ]);
        if ($validator->fails()) {

            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $request_data = $request->all();
            $users = Users::where(array('username' => $request_data['username'], 'record_status' => 1, 'status' => 1))->first();
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
                   /* Mail::send('auth.emails.password', ['user' => $users], function ($m) use ($users) {
                        $m->from('gopi543.maturu@gmail.com', 'Your Application :: CheckList');

                        $m->to($users->email, $users->name)->subject('Your Reminder :: CheckList!');
                    });*/


                    $result = array('error' => false, 'message' => "One time password was sent to your email/$number .");
                } else {
                    $result = array('error' => true, 'message' => "Username doesn't match.");
                }
            } else {
                $result = array('error' => true, 'message' => "Username doesn't match.");
            }
        }
        return Response::json($result, 200);
    }
    

}
