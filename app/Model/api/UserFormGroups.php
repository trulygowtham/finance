<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;

class UserFormGroups extends Model {

    protected $table = 'user_form_groups';
    protected $fillable = ['user_form_id', 'group_id', 'created_by', 'created_at'];

    public static function assignFormGroups($postArr) {
        $sessionInfo = Session::all();
        $page = '';
        foreach ($postArr['groups'] as $postRow) {
            $insertArr = array(
                'user_form_id' => $postArr['user_form_id'],
                'group_id' => $postRow,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $sessionInfo['user'][0]['id']);
            $page = UserFormGroups :: create($insertArr);
        }

        if ($page) {
            return $page->id;
        } else {
            return 0;
        }
    }

}
