<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MYController;
use App\Http\Requests\UserPostRequest;
use App\Users;
use App\Model\Group;
use App\Model\LinkUserGroups;
use App\Model\Auditlogs;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;

class UserController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {

        $data['users'] = Users::getUsersList($role_id=array(1));
        $content_page = 'admin/users/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function getData() {

        return Datatables::of(Users::getUsersList($role_id=array(1)))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            $buttons.='<a href="' . route("admin.users.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            $buttons.=' <a href="' . route("admin.users.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='<a href="' . route("admin.users.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this user?'" . ')" >';
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
        $content_page = 'admin/users/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(UserPostRequest $request) {
        if ($request['profile_avatar'] != '') {
            $imageName = 'user_' . time() . '.' . $request['profile_avatar']->getClientOriginalExtension();

            $request['profile_avatar']->move(public_path('images'), $imageName);
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'group_id');
            $inputs['profile_avatar'] = $imageName;
        } else {
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'group_id');
        }
        $inputs['role_id'] = '1';
        $inputs['password'] = md5($request['password']);
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $created_at = date('Y-m-d H:i:s');
        $inputs['created_by'] = $created_by;
        $inputs['admin_id'] = $session_data['admin_id'];
        $page = Users::create($inputs);
        
        $username = $request['username'];
        if ($page != '') {
            //update user groups
            /*$group_arr = $request['group_id'];
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];
            $created_at = date('Y-m-d H:i:s');
            if (count($group_arr) > 0) {
                // LinkUserGroups::deleteUserGroups(base64_decode($id));
                foreach ($group_arr as $group_row) {
                    if ($group_row != '') {
                        $insert_arr = array('user_id' => $page->id, 'group_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }*/
            //category tab type  auditlogs added
            $message = "User # $username created successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        if ($page != '') {
            return redirect()->route('admin.users')->with('success-status', "User # $username created successfully!");
        } else {
            return redirect()->route('admin.users')->with('error-status', "User creating failed!");
        }
    }

    public function edit($id) {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['groups'] = $groups = Group::getGroupList($created_by);
        $user_groups = $data['user_groups']   = LinkUserGroups::select('group_id')->where('user_id',base64_decode($id))->select('group_id')->get();
       
        $data['users'] = $users = Users::whereId(base64_decode($id))->first();
        $content_page = 'admin/users/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function view($id) {
        $data['users'] = $users = Users::whereId(base64_decode($id))->first();
        $content_page = 'admin/users/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(UserPostRequest $request, $id) {

        if ($request['profile_avatar'] != '') {

            $imageName = 'user_' . time() . '.' . $request['profile_avatar']->getClientOriginalExtension();

            $request['profile_avatar']->move(public_path('images'), $imageName);
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'confirm_password', 'password', 'isChangePass', 'group_id');
            $inputs['profile_avatar'] = $imageName;
        } else {
            $inputs = $request->except('_token', '_method', 'profile_avatar', 'confirm_password', 'password', 'isChangePass', 'group_id');
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
            //update user groups
            /*$group_arr = $request['group_id'];

            if (count($group_arr) > 0) {
                LinkUserGroups::deleteUserGroups(base64_decode($id));
                foreach ($group_arr as $group_row) {
                    if ($group_row != '') {
                        $insert_arr = array('user_id' => base64_decode($id), 'group_id' => $group_row, 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }*/
            //category tab type  auditlogs added
            $message = "User # $username updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        return redirect()->route('admin.users')->with('success-status', "User#$username updated successfully!");
    }

    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Users::where('id', base64_decode($id))->update($inputs);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "User deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        return redirect()->route('admin.users')->with('success-status', 'User deleted successfully!');
    }

}
