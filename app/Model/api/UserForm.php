<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserForm extends Model {

    protected $table = 'user_forms';
    protected $fillable = ['user_id', 'form_id', 'room_no', 'description', 'date', 'form_info', 'created_at', 'created_by', 'admin_id'];

    public static function addUserForm($postdata) {
        $sessionInfo = Session::all();
        $logdata = array(
            'user_id' => $postdata['user_id'],
            'form_id' => $postdata['form_id'],
            'room_no' => isset($postdata['room_no']) ? $postdata['room_no'] : '',
            'description' => isset($postdata['description']) ? $postdata['description'] : '',
            'date' => isset($postdata['date']) ? $postdata['date'] : '',
            'form_info' => $postdata['form_info'],
            'created_at' => date("Y-m-d H:i:s"),
            'admin_id' => $sessionInfo['user'][0]['created_by'],
            'created_by' => $sessionInfo['user'][0]['id']);
        $page = UserForm::create($logdata);
        $userFormId = $page->id;
        $ticket_id = 'CH' . str_pad($userFormId, 5, '0', STR_PAD_LEFT);
        $updateInfo = array('form_number' => $ticket_id);
        $isUpdated = UserForm::where('id', $userFormId)->update($updateInfo);
        if ($isUpdated) {
            return $userFormId;
        } else {
            return 0;
        }
    }

    public static function updateUserForm($postdata) {
        $sessionInfo = Session::all();
        $logdata = array(
            'form_info' => ($postdata['form_info']),
            'updated_at' => date('Y-m-d H:i:s'));

        $userFormId = $postdata['id'];

        $isUpdated = UserForm::where('id', $userFormId)->update($logdata);
        if ($isUpdated) {
            return $userFormId;
        } else {
            return 0;
        }
    }

    public static function updateUserFormStatus($postdata) {
        $sessionInfo = Session::all();
        $logdata = array(
            'status' => $postdata['status'],
            'updated_at' => date('Y-m-d H:i:s'));

        $userFormId = $postdata['id'];

        $isUpdated = UserForm::where('id', $userFormId)->update($logdata);
        if ($isUpdated) {
            return $userFormId;
        } else {
            return 0;
        }
    }

    public static function getUserFormInfo($userFormId = 0) {
        return UserForm::join('forms', 'forms.id', '=', 'user_forms.form_id')
                        ->where(array('user_forms.record_status' => 1, 'user_forms.id' => $userFormId))->orderBy('user_forms.id', 'desc')
                        ->select('user_forms.*', 'forms.name as form_name')
                        ->get()->first();
    }

    public static function getUserFormList($userId = 0) {
        return UserForm::join('forms', 'forms.id', '=', 'user_forms.form_id')
                        ->where(array('user_forms.record_status' => 1, 'user_forms.user_id' => $userId))->orderBy('user_forms.id', 'desc')
                        ->select('user_forms.*', 'forms.name as form_name')
                        ->get();
    }

    public static function getUserFormLists($userId = 0, $userFormArr = array()) {
        return UserForm::join('forms', 'forms.id', '=', 'user_forms.form_id')
                        ->where(function($query) use ($userId, $userFormArr) {
                            $query->where('user_forms.user_id', $userId)->orWhere('user_forms.accepted_user', $userId)->orWhereIn('user_forms.id', $userFormArr);
                        })
                        ->where(array('user_forms.record_status' => 1))->orderBy('user_forms.id', 'desc')
                        ->select('user_forms.*', 'forms.name as form_name')
                        ->get();
    }

    public static function getUserForms($user_id = 0, $from_date = '', $to_date = '') {
        $session_data = Session::all();
        $role_id = $session_data['user'][0]['role_id'];
        $login_id = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id'];
        $whereArr = array();
        $whereArr['user_forms.record_status'] = 1;
        if ($user_id > 0) {
            $whereArr['user_forms.user_id'] = $user_id;
        }

        return UserForm::join('forms', 'forms.id', '=', 'user_forms.form_id')
                        ->join('users', 'users.id', '=', 'user_forms.user_id')
                        ->where($whereArr)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('user_forms.created_at', '>=', dateDbFormat($from_date) . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('user_forms.created_at', '<=', dateDbFormat($to_date) . ' 23:59:59');
                            }
                        })
                        ->where(function($query) use ($role_id, $admin_id, $login_id) {
                            if ($role_id == 4) {
                                return $query->whereIn('user_forms.created_by', array($admin_id, $login_id));
                            } else {
                                return $query->whereIn('user_forms.admin_id', array($admin_id, $login_id));
                            }
                        })->orderBy('user_forms.id', 'desc')
                        ->select('user_forms.*', 'forms.name as form_name', "users.name", "users.last_name", "users.title")
                        ->get();
    }

    public static function getCompletedUserForms($user_id = 0, $from_date = '', $to_date = '') {
        $session_data = Session::all();
        $role_id = $session_data['user'][0]['role_id'];
        $login_id = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id'];
        $whereArr = array();
        $whereArr['user_forms.record_status'] = 1;
        if ($user_id > 0) {
            $whereArr['user_forms.user_id'] = $user_id;
        }
        return UserForm::join('forms', 'forms.id', '=', 'user_forms.form_id')
                        ->join('users', 'users.id', '=', 'user_forms.user_id')
                        ->where($whereArr)
                        ->where('user_forms.status', 2)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('user_forms.updated_at', '>=', dateDbFormat($from_date) . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('user_forms.updated_at', '<=', dateDbFormat($to_date) . ' 23:59:59');
                            }
                        })
                        ->where(function($query) use ($role_id, $admin_id, $login_id) {
                            if ($role_id == 4) {
                                return $query->whereIn('user_forms.created_by', array($admin_id, $login_id));
                            } else {
                                return $query->whereIn('user_forms.admin_id', array($admin_id, $login_id));
                            }
                        })->orderBy('user_forms.id', 'desc')
                        ->select('user_forms.*', 'forms.name as form_name', "users.name", "users.last_name", "users.title")
                        ->get();
    }

    //function to get user forms count
    public static function getUserFormsCount($user_id = 0, $from_date = '', $to_date = '') {

        // DB::enableQueryLog();
        $session_data = Session::all();
        $role_id = $session_data['user'][0]['role_id'];
        $login_id = $session_data['user'][0]['id'];
        $admin_id = $session_data['admin_id'];
        $whereArr = array();
        $whereArr['user_forms.record_status'] = 1;
        if ($user_id > 0) {
            $whereArr['user_forms.user_id'] = $user_id;
        }
        return UserForm::join('users', 'users.id', '=', 'user_forms.user_id')
                        ->where($whereArr)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('user_forms.updated_at', '>=', dateDbFormat($from_date) . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('user_forms.updated_at', '<=', dateDbFormat($to_date) . ' 23:59:59');
                            }
                        })
                        ->where(function($query) use ($role_id, $admin_id, $login_id) {
                            if ($role_id == 4) {
                                return $query->whereIn('user_forms.created_by', array($admin_id, $login_id));
                            } else {
                                return $query->whereIn('user_forms.admin_id', array($admin_id, $login_id));
                            }
                        })
                        ->orderBy('user_forms.id', 'desc')
                        ->select('users.name', 'users.last_name', DB::raw('sum(IF(user_forms.status=2,1,0)) as completed_cnt'), DB::raw('sum(IF(user_forms.status=1,1,0)) as pending_cnt'), DB::raw('sum(IF(user_forms.status=3,1,0)) as cancelled_cnt'))
                        ->groupBy('user_forms.user_id')
                        ->get();
        //$query = DB::getQueryLog(); 
        //  print_r($query);die();
    }

    public static function getFormCount($from_date = '', $to_date = '', $status, $admin_id) {

        return UserForm::where(array('record_status' => 1, 'status' => $status, 'admin_id' => $admin_id))
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('updated_at', '>=', $from_date . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('updated_at', '<=', $to_date . ' 23:59:59');
                            }
                        })
                        ->get();
    }

}
