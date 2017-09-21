<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class LinkFormGroups extends Model {

    protected $table = 'link_form_groups';
    protected $fillable = ['form_id', 'group_id', 'created_by', 'created_at'];

    public static function createFormGroups($groupArr) {


        $page = LinkFormGroups :: create($groupArr);
        return $page;
    }

    public static function deleteFormGroups($form_id = 0, $group_id = 0) {

        if ($form_id > 0) {
            $page = LinkFormGroups :: where('form_id', $form_id)->delete();
            return $page;
        }else if ($group_id > 0) {
            $page = LinkFormGroups :: where('group_id', $group_id)->delete();
            return $page;
        }
    }

}
