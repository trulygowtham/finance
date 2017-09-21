<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;

class UserFormUsers extends Model {

    protected $table = 'user_form_users';
    protected $fillable = ['user_form_id', 'user_id', 'created_by', 'created_at'];

    public static function assignFormUsers($postArr) {
        $sessionInfo = Session::all();
        $page = '';
        foreach ($postArr['users'] as $postRow) {
            $insertArr = array(
                'user_form_id' => $postArr['user_form_id'],
                'user_id' => $postRow,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $sessionInfo['user'][0]['id']);
            $page = UserFormUsers :: create($insertArr);
        }
        if ($page) {
            return $page->id;
        } else {
            return 0;
        }
    }

}
