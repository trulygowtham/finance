<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
//Custom loading
use App\Http\Controllers\MYController;
use App\Http\Requests\GroupPostRequest;
use App\Model\Group;
use App\Users;
use App\Model\LinkUserGroups;
use App\Model\Auditlogs;
use Auth;
use DB;
//use Datatables;
use Session;
//For Datatables
use yajra\Datatables\Datatables;

class GroupController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['users'] = $users = Group::getGroupList($created_by);
        $content_page = 'group/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function anyData() {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        return Datatables::of(Group::getGroupList($created_by))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            $buttons.='<a href="' . route("group.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            $buttons.=' <a href="' . route("group.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='<a href="' . route("group.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this group?'" . ')" >';
                            $buttons.='<div class="pull-right btn btnIcon bgRed btnCancel mrzR5"> &nbsp; </div>  </a>';
                            $buttons.='</div>';
                            return $buttons;
                        })->make(true);
    }

    public function create() {
        $data = array();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['users'] = Users::getUsersList($role_id = array(2), $created_by);
        $content_page = 'group/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(GroupPostRequest $request) {
        $inputArr = $request->all();
        $session_data = Session::all();
        $inputArr['created_by'] = $session_data['user'][0]['id'];
        $inputArr['admin_id'] = $session_data['user'][0]['id'];
        $page = Group::create($inputArr);
        $catName = $inputArr['name'];
        if ($page != '') {
            //update user groups
            $user_arr = $request['user_id'];
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];
            //$admin_id = $session_data['user'][0]['created_by'];
            $created_at = date('Y-m-d H:i:s');
            if (count($user_arr) > 0) {
                // LinkUserGroups::deleteUserGroups(base64_decode($id));
                foreach ($user_arr as $user_row) {
                    if ($user_row != '') {
                        $insert_arr = array('user_id' => $user_row, 'group_id' => $page->id, 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }
            //category tab type  auditlogs added
            $message = "Group #$catName  created successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '6');
        }

        return redirect()->route('group')->with('success-status', "Group #$catName  created successfully!");
    }

    public function edit($id) {
        $data['groups'] = Group::whereId(base64_decode($id))->first();
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['users'] = Users::getUsersList($role_id = array(2), $created_by);
        $user_groups = $data['user_groups'] = LinkUserGroups::select('user_id')->where('group_id', base64_decode($id))->select('user_id')->get();
        $content_page = 'group/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(GroupPostRequest $request, $id) {
        $inputs = $request->except('_token', '_method', 'user_id');
        $page = Group::where('id', base64_decode($id))->update($inputs);
        $catName = $inputs['name'];
        if ($page != '') {
            //update user groups
            $user_arr = $request['user_id'];
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];
            $created_at = date('Y-m-d H:i:s');
            if (count($user_arr) > 0) {
                LinkUserGroups::deleteUserGroups(0, base64_decode($id));
                foreach ($user_arr as $user_row) {
                    if ($user_row != '') {
                        $insert_arr = array('user_id' => $user_row, 'group_id' => base64_decode($id), 'created_at' => $created_at, 'created_by' => $created_by);
                        LinkUserGroups::createUserGroups($insert_arr);
                    }
                }
            }
            //category tab type  auditlogs added
            $message = "Group #$catName  updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '6');
        }

        return redirect()->route('group')->with('success-status', "Group #$catName updated successfully!");
    }

    public function view($id) {
        $session_data = Session::all();
        $created_by = $session_data['user'][0]['id'];
        $data['users'] = Users::getUsersList($role_id = array(2), $created_by);
        $data['user_groups'] = LinkUserGroups::select('user_id')->where('group_id', base64_decode($id))->select('user_id')->get();
        $data['groups'] = Group::whereId(base64_decode($id))->first();
        $content_page = 'group/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Group::where('id', base64_decode($id))->update($inputs);
        if ($page != '') {
            //category tab type  auditlogs added
            $message = "Group deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '6');
        }
        return redirect()->route('group')->with('success-status', 'Group deleted successfully!');
    }

}
