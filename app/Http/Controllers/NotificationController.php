<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\MYController; 
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use yajra\Datatables\Datatables;
use App\Model\NotificationsReceiver;
use Illuminate\Support\Facades\Validator;
class NotificationController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }
    public function index() {
        $sessionInfo = Session::all();
        $created_by = $sessionInfo['user'][0]['id'];
        $data['users'] = NotificationsReceiver::getNotificationList($created_by);
        $content_page = 'notifications/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }
    public function getData() {
        $sessionInfo = Session::all();
        $created_by = $sessionInfo['user'][0]['id'];
        return Datatables::of(NotificationsReceiver::getNotificationList($created_by))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>"; 
                            if($query->notification_type_id==1){
                                $link='form.view';
                            }else{
                                $link='form.userFormView';
                            }
                            $buttons.=' <a href="' . route("$link", base64_encode($query->notification_links)) . '" onclick="readNote("'.$query->id.'")"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='</div>';
                            return $buttons;
                        })->setRowClass(function ($user) {
                            return $user->read_status == 1 ? 'alert-success' : '';
                        })->make(true);
    }
 
    public function updateNotification(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    
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
        echo json_encode($result) ;
    }

}
