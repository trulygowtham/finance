<?php

namespace App\Http\Middleware;

use Closure;
//external use
use \Crypt;
use App\Users;
use App\Model\api\Api;
use Session;
use Response;

class AuthMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //add in api log
        Api::addApilogs($request);
        $post_data = $request->all();
        $userid = isset($post_data['userid']) ? $post_data['userid'] : 0;
        $api_token = isset($post_data['api_token']) ? $post_data['api_token'] : '';

        if ($api_token != '') {
            $checkApiToken = Users::where(array('api_token' => $api_token, 'record_status' => 1))->first();
            if (!EMPTY($checkApiToken) && count($checkApiToken) > 0) {
                $acckey = Crypt::decrypt($api_token);
                $accessArr = explode('@#@', $acckey);
                $userid = isset($accessArr[0]) ? $accessArr[0] : 0;
                $users = Users::where(array('id' => $userid, 'api_token' => $api_token, 'record_status' => 1))->first();

                if (!EMPTY($users) && count($users) > 0) {
                    $status = isset($users['attributes']['status']) ? $users['attributes']['status'] : 0;
                    if ($status == 1) {
                        $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
                        $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
                        $username .= isset($users['attributes']['last_name']) ? ' ' . $users['attributes']['last_name'] : '';
                        $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
                        $usertitle = isset($users['attributes']['title']) ? $users['attributes']['title'] : '';
                        $created_by = isset($users['attributes']['created_by']) ? $users['attributes']['created_by'] : 0;
                        $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail, 'title' => $usertitle,'created_by'=>$created_by);
                        if (Session::has('user')) {
                            $request->session()->forget('user');
                        }
                        Session::push('user', $userInfo);

                        return $next($request);
                    } else {
                        $result = array('error' => true, 'message' => "User is in in-active state.");
                    }
                } else {
                    $result = array('error' => true, 'message' => "User doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'message' => "Api Key doesn't exist.");
            }
        } else {
            $result = array('error' => true, 'message' => "Api Key doesn't exist.");
        }
        return Response::json($result, 200);
    }

}
