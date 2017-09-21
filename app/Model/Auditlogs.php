<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Auditlogs extends Model {

    protected $table = 'auditlogs';
    protected $fillable = ['message', 'tabtype', 'created_at', 'login_id', 'created_name', 'ip_address', 'date', 'admin_id'];

    public static function getAuditList($post_data = array()) {

        $sessionInfo = Session::all();
        $admin_id = $sessionInfo['user'][0]['id'];
        $module_id = isset($post_data['module_id'])?$post_data['module_id']:0;
        $whereArr = array();
        if($module_id>0){
            $whereArr = array('admin_id'=>$admin_id,'tabtype'=>$module_id);
        }else{
            $whereArr = array('admin_id'=>$admin_id);
        }
        //DB::statement(DB::raw('set @rownum=0'));DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
        $result = auditlogs :: select('auditlogs.*')
                ->where($whereArr)
                ->orderBy('id', 'desc')->get();
        /*if (isset($post_data['module_id']) && $post_data['module_id'] > 0) {
            $result->where('tabtype', $post_data['module_id']);
        }
        $result->where('admin_id',$admin_id);
        $result->orderBy('id', 'desc')->get();*/
        return $result;
    }

    public static function addAuditlogs($message, $tabtype = '6',$admin_id=0) {
        if (Session::has('user')) {
            
            $sessionInfo = Session::all();
            $admin_id = ($admin_id==0)?$sessionInfo['user'][0]['id']:$admin_id;
            $logdata = array(
                'admin_id' => $admin_id,
                'login_id' => $sessionInfo['user'][0]['id'],
                'created_name' => $sessionInfo['user'][0]['name'],
                'message' => $message,
                'tabtype' => $tabtype,
                'ip_address' => $_SERVER['SERVER_ADDR'],
                'created_at' => date("Y-m-d H:i:s"),
                'date' => date("Y-m-d H:i:s"));
            $page = auditlogs::create($logdata);
            return 1;
        }
        return 0;
    }

}
