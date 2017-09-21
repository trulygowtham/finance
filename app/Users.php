<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Crypt;
use Session;
class Users extends Model {

    protected $table = 'users';
    protected $fillable = ['name', 'last_name', 'title', 'email', 'phone', 'username', 'password', 'role_id','created_by','admin_id'];

    public static function getUsersList($role_id=array(2),$admin_id=0,$groupArr=array()) {
         $session_data = Session::all(); 
        $login_id = $session_data['user'][0]['id'];
        $login_role_id = $session_data['user'][0]['role_id'];
        $admin_id = $session_data['admin_id'];
        
        $whereArr = array(); 
        if($admin_id>0){
            if($login_role_id==4){
                $whereArr = array('users.record_status' => 1, 'users.created_by' => $admin_id);
            }else{
                $whereArr = array('users.record_status' => 1, 'users.admin_id' => $admin_id);
            }
            
        }else{
            $whereArr = array( 'users.record_status' => 1);
        }
        
        if(count($groupArr)>0){
            return users::select('users.*')->selectRaw('group_concat(groups.name SEPARATOR  ", ") as group_name')
                ->leftJoin('link_user_groups', 'link_user_groups.user_id', '=', 'users.id')
                ->leftJoin('groups', 'groups.id', '=', 'link_user_groups.group_id')
                ->orderBy('users.created_at', 'desc')
                ->where(array( 'users.record_status' => 1))
                ->whereIn('link_user_groups.group_id',$groupArr)
                ->whereIn('users.role_id',$role_id)
                ->groupBy('users.id')
                ->get();
        }else{
            return users::select('users.*')->selectRaw('group_concat(groups.name SEPARATOR  ", ") as group_name')
                ->leftJoin('link_user_groups', 'link_user_groups.user_id', '=', 'users.id')
                ->leftJoin('groups', 'groups.id', '=', 'link_user_groups.group_id')
                ->orderBy('users.created_at', 'desc')
                ->where($whereArr)
                ->whereIn('users.role_id',$role_id)
                ->groupBy('users.id')
                ->get();
        }
        
    }
    public static function getUserInfo($role_id=2,$admin_id=0) {
        $whereArr = array();
        if($admin_id>0){
            $whereArr = array('users.role_id' => $role_id, 'users.record_status' => 1, 'users.created_by' => $admin_id);
        }else{ 
            $whereArr = array('users.role_id' => $role_id, 'users.record_status' => 1);
        }
        return users::select('users.*')
                ->orderBy('users.name', 'asc')
                ->where($whereArr) 
                ->get();
    }
    public static function newAccessToken($user_id,$request_data=array()) {
        $acckey = ($user_id)."@#@".time();
	$acckey = Crypt::encrypt($acckey);
	//$acckey = Crypt::decrypt($acckey);
        $inputs = array();
        $inputs['api_token'] = $acckey;
        $inputs['last_login'] = date('Y-m-d H:i:s'); 
        $other_info = isset($request_data['other_info'])?$request_data['other_info']:array();
        $inputs['other_info'] =  serialize($other_info);
        Users::where('id', $user_id)->update($inputs);
        return $acckey;
    }
    public static function deleteAccessToken($user_id) { 
        $inputs = array();
        $inputs['api_token'] = '';
        //$inputs['last_login'] = date('Y-m-d H:i:s');
        Users::where('id', $user_id)->update($inputs);
        return 1;
    }

}
