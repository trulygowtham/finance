<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Users;
use App\Model\Form;
use App\Model\Group;
use App\Model\LinkUserGroups;
use App\Model\api\UserForm;

use App\Model\api\UserFormHistory;
use App\Model\Questions;
use Session; 

//customers
use App\Model\api\Customers;
use App\Model\api\CustomersPayments;

class CustomerController extends Controller {

    public function __construct() {
        // $this->is_logged_in();
    }

    public function create(Request $request) {

     
		$validator = Validator::make($request->all(), [
                    'first_name' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
        ]);
        if ($validator->fails()) { 
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $request_data = $request->all();
            
			 $inputArr['name'] = $request_data['first_name'];
			 $inputArr['email'] = $request_data['email'];
			 $inputArr['phone'] = $request_data['phone'];
			 $inputArr['address'] = $request_data['address'];
			 $inputArr['amount'] = $request_data['amount'];
			 $inputArr['created_by'] = $request_data['user_id'];
			$page = Customers::create($inputArr);
                
                if ($page) { 
                    $result = array('error' => false, 'message' => "Customer created successfully.");
                } else {
                    $result = array('error' => true, 'message' => "Customer creation failed.");
                }
             
        }
        return Response::json($result, 200);
		 
    }
	public function customerPayment(Request $request) {

     
		$validator = Validator::make($request->all(), [
                    'customer_id' => 'required',
                    'paidamount' => 'required',
					'seldate' => 'required',
        ]);
		// 
        if ($validator->fails()) { 
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $request_data = $request->all();
            
			 $inputArr['customer_id'] = $request_data['customer_id'];
			 $inputArr['amount'] = $request_data['paidamount'];
			 $inputArr['date'] = $request_data['seldate'];
			 $inputArr['description'] = $request_data['description'];
			 $inputArr['created_by'] = 1;
			 $inputArr['status'] = 1;
			 $inputArr['admin_id'] = $request_data['user_id'];
			$page = CustomersPayments::create($inputArr);
                
                if ($page) { 
                    $result = array('error' => false, 'message' => "Customer Payment created successfully.");
                } else {
                    $result = array('error' => true, 'message' => "Customer Payment creation failed.");
                }
             
        }
        return Response::json($result, 200);
		 
    }
    public function customerList(Request $request) {

        $post_data = $request->all(); 
        $userArr = array();
        //$session_data = Session::all();
        $created_by = $post_data['user_id'];
        $user_data = Customers::getCustomerInfo($created_by);
        if (!EMPTY($user_data) && count($user_data) > 0) {
            
            $result = array('error' => false, 'list' => $user_data, 'message' => "Customer Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => array(), 'message' => "Customer Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
	public function userDates(Request $request) {

        $post_data = $request->all(); 
        $userArr = array(); 
        $users = Users::where(array('id' => $post_data['user_id'], 'record_status' => 1, 'status' => 1))->first();
        if (!EMPTY($users) && count($users) > 0) {
                $week_no = isset($users['attributes']['week_no']) ? $users['attributes']['week_no'] : 0;
				$dateArr = $this->getDates($week_no);
				
            
            $result = array('error' => false, 'list' => $dateArr, 'message' => "Customer Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => array(), 'message' => "Customer Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
	public function getDates($week_no){
		$curdate = date('Y-m-d');
				if($week_no==0){
					  $start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Monday'));
				}
				if($week_no==1){
					  $start = (date('D') != 'Tue') ? date('Y-m-d', strtotime('last Tuesday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Tuesday'));
				}
				if($week_no==2){
					  $start = (date('D') != 'Wed') ? date('Y-m-d', strtotime('last Wednesday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Wednesday'));
				}
				if($week_no==3){
					  $start = (date('D') != 'Thu') ? date('Y-m-d', strtotime('last Thursday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Thursday'));
				}
				if($week_no==4){
					  $start = (date('D') != 'Fri') ? date('Y-m-d', strtotime('last Friday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Friday'));
				}
				if($week_no==5){
					  $start = (date('D') != 'Sat') ? date('Y-m-d', strtotime('last Saturday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Saturday'));
				}
				if($week_no==6){
					  $start = (date('D') != 'Sun') ? date('Y-m-d', strtotime('last Sunday')) : date('Y-m-d');
					  $finish = date('Y-m-d', strtotime($start.'last Sunday'));
				}
				
				return $dateArr = array('week1'=>array('fulldate'=>$finish,'date'=>date('d M',strtotime($finish))),'week2'=>array('fulldate'=>$start,'date'=>date('d M',strtotime($start))));
	}
	public function paymentList(Request $request) {

        $post_data = $request->all(); 
        $userArr = array();
        //$session_data = Session::all();
        $admin_id = $post_data['user_id'];
        $user_data = Customers::getCustomerInfo($admin_id);
		$customer_data = array();
		$totalArr = array();
		foreach($user_data as $key=>$row){
			$customer_data[$key] = $row;
			$customer_payments = CustomersPayments::getCustomerPayments($row['id']);
			$paymentArr = array();
			foreach($customer_payments as $ckey =>$crow){
				$paymentArr[$crow['date']] = $crow['amount'];//$crow['date']
				$totalArr[$crow['date']][] = $crow['amount'];//$crow['date']
			}
			$customer_data[$key]['payments'] = $paymentArr;
		}
		foreach($totalArr as $tkey=>$trow){
			$totalArr[$tkey] = array_sum($trow);
		}
        if (!EMPTY($customer_data) && count($customer_data) > 0) {
            
            $result = array('error' => false, 'list' => $customer_data,'totalAmount'=>$totalArr, 'message' => "Customer Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => array(), 'message' => "Customer Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
	public function customerView(Request $request) {

        $post_data = $request->all(); 
        $userArr = array();
        //$session_data = Session::all();
        $admin_id = $post_data['user_id'];
        $customer_id = isset($post_data['customer_id'])?$post_data['customer_id']:0;
		if($customer_id>0){
			 $user_data = Customers::where(array('id' => $post_data['customer_id']))->get();
		}else{
			 $user_data = Customers::where(array('record_status' => 1))->get();
		}
       
		$customer_data = array();
        if (!EMPTY($user_data) && count($user_data) > 0) {
                //$id = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
		$customer_data = array();
		foreach($user_data as $key=>$row){
			$customer_data[$key] = $row;
			$customer_payments = CustomersPayments::getCustomerPayments($row['id']);
			$paymentArr = array();
			foreach($customer_payments as $ckey =>$crow){
				$paymentArr[$ckey] = $crow;//$crow['date']
			}
			$customer_data[$key]['payments'] = $paymentArr;
		}
		}
        if (!EMPTY($customer_data) && count($customer_data) > 0) {
            
            $result = array('error' => false, 'list' => $customer_data, 'message' => "Customer Info feteched succssfully.");
        } else {
            $result = array('error' => true, 'list' => array(), 'message' => "Customer Info  doesn't exist.");
        }


        return Response::json($result, 200);
    }
    public function changePassword(Request $request) {
        
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) { 
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $request_data = $request->all();
            $users = Users::where(array('id' => $request_data['user_id'], 'record_status' => 1, 'status' => 1))->first();
            if (!EMPTY($users) && count($users) > 0) {
                $userid = isset($users['attributes']['id']) ? $users['attributes']['id'] : 0;
                $username = isset($users['attributes']['name']) ? $users['attributes']['name'] : '';
                $useremail = isset($users['attributes']['email']) ? $users['attributes']['email'] : '';
                $userInfo = array('name' => $username, 'id' => $userid, 'email' => $useremail);
                if ($userid > 0) {
 
                    $inputs = array();
                    $inputs['tmp_password'] = '';
                    $inputs['password'] = md5($request_data['password']);
                    Users::where('id', $userid)->update($inputs);
                    /*Mail::send('auth.emails.password', ['user' => $users], function ($m) use ($users) {
                        $m->from('gopi543.maturu@gmail.com', 'Your Application :: CheckList');

                        $m->to($users->email, $users->name)->subject('Your Reminder :: CheckList!');
                    });*/


                    $result = array('error' => false, 'message' => "Password changed successfully.");
                } else {
                    $result = array('error' => true, 'message' => "User doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'message' => "User doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }
}
