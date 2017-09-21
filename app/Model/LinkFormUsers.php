<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class LinkFormUsers extends Model {

    protected $table = 'link_form_users';
    protected $fillable = ['form_id', 'user_id', 'created_by', 'created_at'];

    public static function createFormUsers($groupArr) {


        $page = LinkFormUsers :: create($groupArr);
        return $page;
    }

    public static function deleteFormUsers($form_id = 0, $user_id = 0) {

        if ($form_id > 0) {
            $page = LinkFormUsers :: where('form_id', $form_id)->delete();
            return $page;
        }else if ($user_id > 0) {
            $page = LinkFormUsers :: where('user_id', $user_id)->delete();
            return $page;
        }
    }

}
