<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Model\Questions;
use App\Users;
use Session;
use DB;

class ApiController extends Controller {

    public function __construct() {

        /* if (Session::has('user')) { 
          Redirect::route('dashboard')->send();
          } else {

          } */
    }

    public function getToken(Request $request) {
        return Response::json(array(
                    'error' => false,
                    'token' => csrf_token(),
                        ), 200);
    }

    public function checkAuth(Request $request) {
        $data = $request->session()->all();
         
        $result = array('error' => false,'list'=>$data['user'][0], 'message' => "Api Key exist.");
        return Response::json($result, 200);
    }

}
