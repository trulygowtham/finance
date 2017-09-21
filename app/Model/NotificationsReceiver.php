<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NotificationsReceiver extends Model {

    protected $table = 'notifications_receiver';
    protected $fillable = ['receiver_id', 'notification_id', 'read_status', 'created_by'];

    public static function createNotificationsReceiver($notifyArr) {

        $noteRes = NotificationsReceiver ::where(array('receiver_id' => $notifyArr['receiver_id'], 'notification_id' => $notifyArr['notification_id']))
                        ->get()->first();
        if (count($noteRes) > 0) {
            return $noteRes;
        } else {
            $page = NotificationsReceiver :: create($notifyArr);
            return $page;
        }
    }

    public static function getNotificationCount($userId) {

        return NotificationsReceiver :: where(array('read_status' => 0, 'receiver_id' => $userId))->orderBy('created_at', 'desc')->get();
    }

    public static function getNotificationList($userId) {
        return NotificationsReceiver :: join('notifications', 'notifications.id', '=', 'notifications_receiver.notification_id')
                        ->where(array('notifications_receiver.receiver_id' => $userId))
                        ->orderBy('notifications.created_at', 'desc')
                        ->select('notifications.*', 'notifications_receiver.id', 'notifications_receiver.notification_id', 'notifications_receiver.read_status')
                        ->get();
    }
    
    public static function getUnreadNotificationList($userId) {
        return NotificationsReceiver :: join('notifications', 'notifications.id', '=', 'notifications_receiver.notification_id')
                        ->where(array('notifications_receiver.read_status' => 0, 'notifications_receiver.receiver_id' => $userId))
                        ->orderBy('notifications.created_at', 'desc')
                        ->select('notifications.*', 'notifications_receiver.id', 'notifications_receiver.notification_id', 'notifications_receiver.read_status')
                        ->get();
    }

}
