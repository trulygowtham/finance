<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MYController;
use App\Http\Requests\ProfilePostRequest;
use App\Users;
use App\Model\Group;
use App\Model\LinkUserGroups;
use App\Model\Auditlogs;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;

class ProfileController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index(Request $request) {
        $session_data = $request->session()->all();
        $user_id = $session_data['user'][0]['id'];
        $data['users'] = $users = Users::whereId($user_id)->first();
        $content_page = 'profile/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function edit(Request $request) {

        $session_data = $request->session()->all();
        $user_id = $session_data['user'][0]['id'];
        $data['users'] = $users = Users::whereId($user_id)->first();
        $content_page = 'profile/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(ProfilePostRequest $request, $id) {

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
        $username = $request['name'];
        if ($page != '') {
            $session_data = Session::all();
            $created_by = $session_data['user'][0]['id'];

            $users = Users::whereId($created_by)->first();

            $session_data['user'][0]['name'] = $users->name . ' ' . $users->last_name;
            $session_data['user'][0]['email'] = $users->email;
            $session_data['user'][0]['title'] = $users->title;
            
            if ($users->profile_avatar !== "") {
                $session_data['user'][0]['profile_avatar'] = url('public/images') . '/' . $users->profile_avatar;                
            }else{
                $session_data['user'][0]['profile_avatar'] = '';
            }

            Session::put("user", $session_data['user']);
            //update user groups
            //category tab type  auditlogs added
            $message = "Profile details # $username updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '3');
        }
        return redirect()->route('profile')->with('success-status', "Profile details #$username updated successfully!");
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
