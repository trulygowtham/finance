<?php

namespace App\Model\api;

use Session;
use Illuminate\Database\Eloquent\Model;
use DB;

class UserFormAnswers extends Model {

    protected $table = 'user_form_answers';
    protected $fillable = ['user_form_qst_id', 'options', 'answer', 'expected_answer', 'created_by', 'created_at'];

    public static function addFormAnswers($postArr) {

        $page = UserFormAnswers :: create($postArr);
        if ($page) {
            return $page->id;
        } else {
            return 0;
        }
    }

    public static function getTotalExpectedCount($from_date = '', $to_date = '') {

        return UserFormAnswers::where('expected_answer', 1)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('created_at', '>=', $from_date . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('created_at', '<=', $to_date . ' 23:59:59');
                            }
                        })
                        ->groupBy('user_form_qst_id')->get();
    }

    public static function getExpectedAnswerCount($expArr = array()) {

        return UserFormAnswers::where('answer', '!=', '')->whereIn('id', $expArr)->groupBy('user_form_qst_id')->get();
    }

    //function to get total questions expected count
    public static function getQuestionsExpectedCount($user_id = 0, $from_date = '', $to_date = '') {

        return UserFormAnswers::join('user_form_questions', 'user_form_questions.id', '=', 'user_form_answers.user_form_qst_id')
                        ->where('expected_answer', 1)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('user_form_answers.created_at', '>=', dateDbFormat($from_date) . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('user_form_answers.created_at', '<=', dateDbFormat($to_date) . ' 23:59:59');
                            }
                        })
                        ->groupBy('user_form_qst_id')
                        ->select('user_form_questions.question_name', 'user_form_questions.question_id', 'user_form_answers.id')
                        ->get();
    }

    //function to get total category expected count
    public static function getCategoriesExpectedCount($user_id = 0, $from_date = '', $to_date = '') {

        return UserFormAnswers::join('user_form_questions', 'user_form_questions.id', '=', 'user_form_answers.user_form_qst_id')
                        ->where('expected_answer', 1)
                        ->where(function($query) use ($from_date) {
                            if ($from_date != '') {
                                return $query->where('user_form_answers.created_at', '>=', dateDbFormat($from_date) . ' 00:00:00');
                            }
                        })->where(function($query) use ( $to_date) {

                            if ($to_date != '') {
                                return $query->where('user_form_answers.created_at', '<=', dateDbFormat($to_date) . ' 23:59:59');
                            }
                        })
                        ->groupBy('user_form_qst_id')
                        ->select('user_form_questions.cat_name', 'user_form_questions.cat_id', 'user_form_answers.id')
                        ->get();
    }

}
