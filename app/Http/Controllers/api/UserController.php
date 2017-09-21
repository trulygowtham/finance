<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Users;
use App\Model\Form;
use App\Model\Group;
use App\Model\LinkUserGroups;
use App\Model\api\UserForm;
use App\Model\api\UserFormHistory;
use App\Model\Questions;
use Session; 

class UserController extends Controller {

    public function __construct() {
        // $this->is_logged_in();
    }

    public function getGroupInfo(Request $request) {

        $post_data = $request->all();


        $groupArr = array();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['created_by'];
        $group_data = Group::getGroupList($created_by);
        if (!EMPTY($group_data) && count($group_data) > 0) {
             
            foreach ($group_data as $key_id => $groupRow) {
                $groupArr[$key_id]['id'] = $groupRow['id'];
                $groupArr[$key_id]['name'] = $groupRow['name'];
                $groupArr[$key_id]['description'] = $groupRow['description'];
                $userArr = array();
                $userData = LinkUserGroups::getGroupUserList($groupRow['id']);
                if (!EMPTY($userData) && count($userData) > 0) {
                    foreach ($userData as $gkey_id => $userRow) {
                        $userArr[$gkey_id]['id'] = $userRow['id'];
                        $userArr[$gkey_id]['name'] = $userRow['name'].' '.$userRow['last_name'];
                        $userArr[$gkey_id]['title'] = $userRow['title'];
                    } 
                }
                $groupArr[$key_id]['users'] = $userArr;
            }  
            $result = array('error' => false, 'list' => $groupArr, 'message' => "Group Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => $groupArr, 'message' => "Group Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
    public function getUserInfo(Request $request) {

        $post_data = $request->all();


        $userArr = array();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['created_by'];
        $user_data = Users::getUserInfo($role_id=2,$created_by);
        if (!EMPTY($user_data) && count($user_data) > 0) {
             
            foreach ($user_data as $key_id => $userRow) {
               $userArr[$key_id]['id'] = $userRow['id'];
                $userArr[$key_id]['name'] = $userRow['name'].' '.$userRow['last_name'];
                $userArr[$key_id]['title'] = $userRow['title'];
            }  
            $result = array('error' => false, 'list' => $userArr, 'message' => "Group Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => $userArr, 'message' => "Group Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
    public function changePassword(Request $request) {
        
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) { 
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $request_data = $request->all();
            $users = Users::where(array('id' => $request_data['user_id'], 'record_status' => 1, 'status' => 1))->first();
            if (!EMPTY($users) && count($users) > 0) {
                $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
                $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
                $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
                $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail);
                if ($userid > 0) {
 
                    $inputs = array();
                    $inputs['tmp_password'] = '';
                    $inputs['password'] = md5($request_data['password']);
                    Users::where('id', $userid)->update($inputs);
                    /*Mail::send('auth.emails.password', ['user' => $users], function ($m) use ($users) {
                        $m->from('gopi543.maturu@gmail.com', 'Your Application :: CheckList');

                        $m->to($users->email, $users->name)->subject('Your Reminder :: CheckList!');
                    });*/


                    $result = array('error' => false, 'message' => "Password changed successfully.");
                } else {
                    $result = array('error' => true, 'message' => "User doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'message' => "User doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }
}
