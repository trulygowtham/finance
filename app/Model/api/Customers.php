<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customers extends Model {

    protected $table = 'customers';
    protected $fillable = ['name',  'email', 'phone', 'created_by','amount'];

     
    public static function getCustomerInfo($admin_id=1) {
        $whereArr = array();
        $whereArr = array('customers.status' => 1, 'customers.created_by' => $admin_id);
        return Customers::select('customers.*')
                ->orderBy('customers.name', 'asc')
                ->where($whereArr) 
                ->get();
    }
     
}
