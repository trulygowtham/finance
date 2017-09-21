<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;

class UserFormHistory extends Model {

    protected $table = 'user_form_history';
    protected $fillable = ['user_form_id', 'form_info', 'created_at','status','created_by'];

    public static function addUserFormHistory($postdata) {
        $sessionInfo = Session::all();
        
        $logdata = array( 
            'user_form_id' => $postdata['id'], 
            'form_info' => $postdata['form_info'],
            'status' => isset($postdata['status'])?$postdata['status']:1,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $sessionInfo['user'][0]['id']);
        
        $page = UserFormHistory::create($logdata);
        $userFormId = $page->id; 
        if ($userFormId) {
            return $userFormId;
        } else {
            return 0;
        }
    }
      
    public static function getUserFormInfo($userFormId=0) {
        return UserFormHistory::where(array('record_status' => 1, 'id' => $userFormId))->orderBy('id', 'desc')->get()->first();
    }

}
