<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class LinkUserGroups extends Model {

    protected $table = 'link_user_groups';
    protected $fillable = ['user_id', 'group_id', 'created_by', 'created_at'];

    public static function createUserGroups($groupArr) {


        $page = LinkUserGroups :: create($groupArr);
        return $page;
    }

    public static function deleteUserGroups($user_id = 0, $group_id = 0) {

        if ($user_id > 0) {
            $page = LinkUserGroups :: where('user_id', $user_id)->delete();
            return $page;
        }else if ($group_id > 0) {
            $page = LinkUserGroups :: where('group_id', $group_id)->delete();
            return $page;
        }
    }
    public static function getGroupUserList($group_id) {
          
        return LinkUserGroups::join('users', 'users.id', '=', 'link_user_groups.user_id')
                ->where('link_user_groups.record_status', 1) 
                ->where('link_user_groups.group_id', $group_id) 
                ->orderBy('users.name', 'asc')
                ->select('users.*')
                ->get();
         
    }

}
