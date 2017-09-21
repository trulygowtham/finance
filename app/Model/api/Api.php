<?php

namespace App\Model\api;


use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Api extends Model {

    protected $table = 'api_log';
    protected $fillable = ['uri', 'method', 'params', 'api_key', 'ip_address', 'created_at'];

    public static function addApilogs($request) {
        $postdata = $request->all();
        $requested_data = serialize($request->all());
        $logdata = array(
            'uri' => str_replace(url('/'), "", $request->url()),
            'method' => $request->method(),
            'params' => $requested_data,
            'api_key' => $postdata['api_token'],
            'ip_address' => $_SERVER['SERVER_ADDR'],
            'created_at' => date("Y-m-d H:i:s"));
        $page = api::create($logdata);
        return 1;
    }

}
