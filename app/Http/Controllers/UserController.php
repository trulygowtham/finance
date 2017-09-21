<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MYController;
use App\Http\Requests\UserPostRequest;
use App\Users;
use App\Model\Group;
use App\Model\LinkUserGroups;
use App\Model\Auditlogs;
use App\Model\Role;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;

class UserController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        $data['users'] = $users = Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr);
        $content_page = 'users/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function getData() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $groupArr = $session_data['user'][0]['group_arr'];
        /* DB::enableQueryLog();
          Users::getUsersList($role_id=array(2,4),$created_by,$groupArr);
          $query = DB::getQueryLog();
          print_r($query);die(); */

        return Datatables::of(Users::getUsersList($role_id = array(2, 4), $created_by, $groupArr))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            $buttons.='<a href="' . route("users.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            $buttons.=' <a href="' . route("users.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='<a href="' . route("users.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this user?'" . ')" >';
                            $buttons.='<div class="pull-right btn btnIcon bgRed btnCancel mrzR5"> &nbsp; </div>  </a>';
                            $buttons.='</div>';
                            return $buttons;
                        })->make(true);
    }

    public function create() {
        $data = array();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['groups'] = $groups = Group::getGroupList($created_by);
        $content_page = 'users/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(UserPostRequest $request) {

        if ($request['profile_avatar'] != '') {
            $imageName = 'user_' . time() . '.' . $request['profile_avatar']->getClientOriginalExtension();

            $request['profile_avatar']->move(public_path('images'), $imageName);
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'group_id', 'dept_group_id');
            $inputs['profile_avatar'] = $imageName;
        } else {
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'group_id', 'dept_group_id');
        }
        $inputs['role_id'] = isset($request['role']) ? $request['role'] : '2';
        $inputs['password'] = md5($request['password']);
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $admin_id = $session_data['admin_id'];
        $created_at = date('Y-m-d H:i:s');
        $inputs['created_by'] = $created_by;
        $inputs['admin_id'] = $admin_id;
        $page = Users::create($inputs);

        $username = $request['username'];
        if ($page != '') {
            //update user groups
            //if dept admin login
            if ($role_id == 4) {
                $group_arr = $session_data['user'][0]['group_arr'];
            } else {
                if ($inputs['role_id'] == 4) {
                    $group_arr = array($request['dept_group_id']);
                } else {
                    $group_arr = $request['group_id'];
                }
            }



            if (count($group_arr) > 0) {
                // LinkUserGroups::deleteUserGroups(base64_decode($id));
                foreach ($group_arr as $group_row) {
                    if ($group_row != '') {
                        $insert_arr = array('user_id' => $page->id, 'group_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }
            //category tab type  auditlogs added
            $message = "User # $username created successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        if ($page != '') {
            return redirect()->route('users')->with('success-status', "User # $username created successfully!");
        } else {
            return redirect()->route('users')->with('error-status', "User creating failed!");
        }
    }

    public function edit($id) {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['groups'] = $groups = Group::getGroupList($created_by);
        $user_groups = $data['user_groups'] = LinkUserGroups::select('group_id')->where('user_id', base64_decode($id))->select('group_id')->get();

        $data['users'] = $users = Users::whereId(base64_decode($id))->first();
        $content_page = 'users/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function view($id) {
        $data['users'] = $users = Users::whereId(base64_decode($id))->first();
        $user_id = isset($users->id)?$users->id:0;
        $role_id = isset($users->role_id)?$users->role_id:0;
        $roleArr = Role::where('id',$role_id)->get()->first();
        $data['role_name'] = isset($roleArr->name)?$roleArr->name:'';
        //groups
        $user_groups = $data['user_groups'] = LinkUserGroups::select('group_id')->where('user_id', $user_id)->select('group_id')->get();
        $groupArr = array();
        if(count($user_groups)>0){
            foreach ($user_groups as $usrKey => $usrRow) {
                $groupRow = Group::where('id',$usrRow->group_id)->select('name')->get()->first();
                $groupArr[] = isset($groupRow->name)?$groupRow->name:'';
            }
        }
        $data['group_name'] = implode(',',$groupArr);
        $content_page = 'users/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(UserPostRequest $request, $id) {

        if ($request['profile_avatar'] != '') {

            $imageName = 'user_' . time() . '.' . $request['profile_avatar']->getClientOriginalExtension();

            $request['profile_avatar']->move(public_path('images'), $imageName);
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'confirm_password', 'password', 'isChangePass', 'group_id', 'dept_group_id');
            $inputs['profile_avatar'] = $imageName;
        } else {
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'confirm_password', 'password', 'isChangePass', 'group_id', 'dept_group_id');
        }
        if (isset($request['isChangePass']) && $request['isChangePass'] == 1) {
            $inputs['password'] = md5($request['password']);
        }
        $created_at = date('Y-m-d H:i:s');
        $page = Users::where('id', base64_decode($id))->update($inputs);
        $username = $request['username'];
        if ($page != '') {
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];
            $role_id = $session_data['user'][0]['role_id'];
            $admin_id = $session_data['admin_id'];
            //update user groups
            //if dept admin login
            if ($role_id == 4) {
                $group_arr = $session_data['user'][0]['group_arr'];
            } else {
                if ($inputs['role_id'] == 4) {
                    $group_arr = array($request['dept_group_id']);
                } else {
                    $group_arr = $request['group_id'];
                }
            }
            //$group_arr = $request['group_id'];

            if (count($group_arr) > 0) {
                LinkUserGroups::deleteUserGroups(base64_decode($id));
                foreach ($group_arr as $group_row) {
                    if ($group_row != '') {
                        $insert_arr = array('user_id' => base64_decode($id), 'group_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }
            //category tab type  auditlogs added
            $message = "User # $username updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        return redirect()->route('users')->with('success-status', "User#$username updated successfully!");
    }

    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Users::where('id', base64_decode($id))->update($inputs);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "User deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        return redirect()->route('users')->with('success-status', 'User deleted successfully!');
    }

}
