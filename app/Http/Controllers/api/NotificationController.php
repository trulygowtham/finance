<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Model\Notifications;
use App\Model\NotificationsReceiver;
use App\Users;
use Session;
use DB;

class NotificationController extends Controller {

    public function __construct() {

        /* if (Session::has('user')) { 
          Redirect::route('dashboard')->send();
          } else {

          } */
    }

    public function notificationCount(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $userId = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($userId > 0) {
                $form_data = NotificationsReceiver::getNotificationCount($userId);

                if (!EMPTY($form_data) && count($form_data) > 0) {
                     
                    $result = array('error' => false, 'count' => count($form_data), 'message' => "Notifications fetched successfully.");
                } else {
                    $result = array('error' => true, 'count' => 0, 'message' => "Notifications not available.");
                }
            } else {
                $result = array('error' => true, 'count' => 0, 'message' => "User doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }
    public function notificationList(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $userId = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($userId > 0) {
                $form_data = NotificationsReceiver::getNotificationList($userId);

                if (!EMPTY($form_data) && count($form_data) > 0) {
                     
                    $result = array('error' => false, 'list' => ($form_data), 'message' => "Notifications fetched successfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "Notifications not available.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }
    public function updateNotification(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'status' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all(); 
            $id = isset($post_data['id']) ? $post_data['id'] : 0;
            $data = array();
            if ($id > 0) {
                $inputs['read_status'] = 1;
                $inputs['updated_at'] = date('Y-m-d H:i:s');
                $page = NotificationsReceiver::where('id', $id)->update($inputs);  
                if ($page) { 
                    $result = array('error' => false, 'list' => ($data), 'message' => "Notifications status updated successfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "Notifications status not updated.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }
}
