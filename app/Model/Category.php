<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Category extends Model {

    protected $table = 'category';
    protected $fillable = ['name', 'description', 'created_by', 'admin_id'];

    public static function getCatList($admin_id = 0, $login_id = 0) {
        $session_data = Session::all();
        $role_id = $session_data['user'][0]['role_id'];
        
        DB::statement(DB::raw('set @rownum=0'));
        if ($admin_id > 0) {
            return category :: select([DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'category.*'])
                    ->whereRecord_status(1)
                     ->where(function($query) use ($role_id,$admin_id,$login_id) { 
                         if($role_id==4){ 
                             return $query->whereIn('created_by', array($admin_id, $login_id));
                         }else{
                             return $query->whereIn('admin_id', array($admin_id, $login_id));
                         }
                        
                    }) 
                    ->orderBy('created_at', 'desc')->get();
        } else {
            return category :: select([DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'category.*'])->whereRecord_status(1)->orderBy('created_at', 'desc')->get();
        }
    }

}
