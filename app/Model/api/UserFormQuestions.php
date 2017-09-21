<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;

class UserFormQuestions extends Model {

    protected $table = 'user_form_questions';
    protected $fillable = ['user_form_id', 'cat_id','cat_name','question_id','question_name','no_of_options', 'created_by', 'created_at'];

    public static function addFormQuestions($postArr) {
        
        $page = UserFormQuestions :: create($postArr); 
        if ($page) {
            return $page->id;
        } else {
            return 0;
        }
    }

}
