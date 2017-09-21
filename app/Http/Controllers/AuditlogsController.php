<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
//Custom loading
use App\Http\Controllers\MYController;
use App\Model\Auditlogs;
use Auth;
use DB;
//use Datatables;
use Session;
//For Datatables
use yajra\Datatables\Datatables;

class AuditlogsController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index(Request $request) {
        $post_data = $request->all();
        $data['module_id'] = isset($post_data['module_id'])?$post_data['module_id']:0;
        $data['modules'] = array('1' => 'Login', '2' => 'Category', '3' => 'User', '4' => 'Questions', '5' => 'Forms', '6' => 'Groups', '7' => 'Others');
        $data['users'] = Auditlogs::getAuditList($post_data); 
        $content_page = 'auditlogs/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function anyData(Request $request) {
        $post_data = $request->all();
        return Datatables::of(Auditlogs::getAuditList($post_data))
                        ->make(true);
    }

}
