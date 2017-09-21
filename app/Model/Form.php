<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Form extends Model {

    protected $table = 'forms';
    protected $fillable = ['name', 'description', 'questions', 'created_by', 'no_of_questions', 'status', 'admin_id'];

    public static function getForms() {
        return Questions::join('category', 'category.id', '=', 'questions.category_id')
                        ->where('questions.record_status', 1)
                        ->where('category.record_status', 1)
                        ->orderBy('questions.created_at', 'desc')
                        ->select('questions.*', 'category.name as category_name')
                        ->get();
    }

    public static function getFormById($id) {
        return Questions::join('category', 'category.id', '=', 'questions.category_id')
                        ->where('questions.record_status', 1)
                        ->where('questions.id', $id)
                        ->where('category.record_status', 1)
                        ->orderBy('questions.created_at', 'desc')
                        ->select('questions.*', 'category.name as category_name')
                        ->get();
    }

    public static function getFormInfo($post_data = array()) {
        /* $result = Form :: whereRecord_status(1);
          if (isset($post_data['id']) && $post_data['id'] > 0) {
          $result->where('id', $post_data['id']);
          }
          $result->orderBy('created_at', 'desc')->get(); */
        return Form::where(array('record_status' => 1, 'status' => 1))->orderBy('name', 'asc')->select('id', 'name', 'description', 'no_of_questions', 'created_at')->get();
    }

    public static function getTotalTemplates() {
        $session_data = Session::all(); 
        $login_id = $session_data['user'][0]['id'];
        $role_id = $session_data['user'][0]['role_id'];
        $admin_id = $session_data['admin_id'];
        return Form::where(array('record_status' => 1))
                ->where(function($query) use ($role_id, $admin_id, $login_id) {
                    if ($role_id == 4) {
                        return $query->whereIn('created_by', array($admin_id, $login_id));
                    } else {
                        return $query->whereIn('admin_id', array($admin_id, $login_id));
                    }
                })
                ->orderBy('created_at', 'asc')->get();
    }

    public static function getTemplateInfo($userFormArr) {
        /* $result = Form :: whereRecord_status(1);
          if (isset($post_data['id']) && $post_data['id'] > 0) {
          $result->where('id', $post_data['id']);
          }
          $result->orderBy('created_at', 'desc')->get(); */
        $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;

        return Form::where(array('record_status' => 1, 'status' => 1))
                        ->whereIn('id', $userFormArr)
                        ->orderBy('name', 'asc')
                        ->select('id', 'name', 'description', 'template_id', 'no_of_questions', 'created_at')->get();
    }

}
