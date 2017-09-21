<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
     protected $table = 'notifications';
     protected $fillable = ['notification_type_id', 'notification_text', 'notification_links', 'created_by', 'created_name', 'admin_id'];
     public static function createNotifications($notifyArr) {
        $noteRes = Notifications ::where(array('notification_text'=>$notifyArr['notification_text'],'notification_links'=>$notifyArr['notification_links'],'created_by'=>$notifyArr['created_by']))
                 ->get()->first();
        if(count($noteRes)>0){
            return $noteRes;
        }else{
            $page = Notifications :: create($notifyArr);
            return $page;
        } 
        
    }
    
}
