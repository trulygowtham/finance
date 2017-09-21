<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;

class Questions extends Model
{
     protected $table = 'questions';
     protected $fillable = ['name', 'description', 'category_id', 'options', 'created_by', 'admin_id'];
     public static function getQuestions($admin_id=0,$login_id=0) {
         $session_data = Session::all();  
        $role_id = $session_data['user'][0]['role_id']; 
          $whereArr = array();
        if($admin_id>0){
            return Questions::join('category', 'category.id', '=', 'questions.category_id')
                ->where(array('questions.record_status' => 1))
                ->where('category.record_status', 1)
                ->where(function($query) use ($role_id, $admin_id, $login_id) {
                    if ($role_id == 4) {
                        return $query->whereIn('questions.created_by', array($admin_id, $login_id));
                    } else {
                        return $query->whereIn('questions.admin_id', array($admin_id, $login_id));
                    }
                }) 
                ->orderBy('questions.created_at', 'desc')
                ->select('questions.*', 'category.name as category_name')
                ->get(); 
        }else{
            return Questions::join('category', 'category.id', '=', 'questions.category_id')
                ->where(array('questions.record_status' => 1))
                ->where('category.record_status', 1)
                ->orderBy('questions.created_at', 'desc')
                ->select('questions.*', 'category.name as category_name')
                ->get();
             
        }
        
     }
     
     public static function getQuestionsById($id) {
        return Questions::join('category', 'category.id', '=', 'questions.category_id')
                ->where('questions.record_status', 1)
                ->where('questions.id', $id)
                ->where('category.record_status', 1)
                ->orderBy('questions.created_at', 'desc')
                ->select('questions.*', 'category.name as category_name')
                ->get();
     }
     
     public static function getQuestionsByIds($ids) {
        return Questions::join('category', 'category.id', '=', 'questions.category_id')
                ->where('questions.record_status', 1)
                ->whereIn('questions.id', $ids)
                ->where('category.record_status', 1)
                ->orderBy('questions.created_at', 'desc')
                ->select('questions.*', 'category.name as category_name')
                ->get();
     }
     
     public static function getQuestionsByCategoryId($id) {
        return Questions::join('category', 'category.id', '=', 'questions.category_id')
                ->where('questions.record_status', 1)
                ->where('category.id', $id)
                ->where('category.record_status', 1)
                ->orderBy('questions.created_at', 'desc')
                ->select('questions.*', 'category.name as category_name')
                ->get();
     }
}
