<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
//
use View;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Model\NotificationsReceiver;

class MYController extends Controller {

    public function is_logged_in() {
        if (Session::has('user')) {
            return true;
        } else {
            Redirect::route('login')->send()->with('error-status', "Please login with username and password.");
        }
    }

    public function generate_default_view($content_page, $data = NULL) {
        /* $view = View::make('layouts/header');
          $view->nest('layouts/sidenav');
          $view->nest($content_page, $data);
          $view->nest('layouts/footer');
          return $view;
          /*View::composers(array(
          'AdminComposer' => array('admin.index', 'admin.profile'),
          'UserComposer' => 'user',
          'ProductComposer@create' => 'product'
          )); */
        // Get unread notification count and data
        $sessionInfo = Session::all();
        $created_by = $sessionInfo['user'][0]['id'];
         $data_header['notifications'] = NotificationsReceiver::getUnreadNotificationList($created_by); 
        
        echo View::make('layouts/header', $data_header)->render();
        echo View::make('layouts/sidenav')->render();
        echo View::make($content_page, $data)->render();
        echo View::make('layouts/footer')->render();
    }

}
