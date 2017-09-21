<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;
use DB;

class CustomersPayments extends Model {

    protected $table = 'customer_payments';
    protected $fillable = ['customer_id',  'amount', 'date', 'created_by','admin_id'];

     
    public static function getCustomerPayments($customer_id=0) {
        $whereArr = array();
        $whereArr = array('customer_payments.status' => 1, 'customer_payments.customer_id' => $customer_id);
        return CustomersPayments::select('customer_payments.*') 
                ->where($whereArr) 
                ->get();
    }
     
}
