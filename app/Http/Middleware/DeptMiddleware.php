<?php

namespace App\Http\Middleware;

use Closure;
//external use
use \Crypt;
use App\Users;
use App\Model\api\Api;
use Session;
use Response;

class DeptMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
       
        if (Session::has('user')) {
            $session_data = Session::all(); 
            
            $id = $session_data['user'][0]['id'];
            $created_by = $session_data['user'][0]['created_by'];
            $role_id = $session_data['user'][0]['role_id'];
            if($role_id==4){
                $admin_id = $created_by;
            }else{
                $admin_id = $id;
            }
            //$request->session()->forget('user');
            Session::put("admin_id", $admin_id);
             
        }
        return $next($request);
         
    }

}
