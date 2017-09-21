<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Group extends Model {

    protected $table = 'groups';
    protected $fillable = ['name', 'description', 'created_by', 'admin_id'];

    public static function getGroupList($admin_id=0) {
        /*$query = Category::select('category.*', 'count(questions.id) as question_cnt');
        $query->leftjoin('questions', function($join) {
            $join->on('category.id', '=', 'questions.category_id');
            $join->where('questions.record_status', 1);
        });
        $query->where('category.record_status', 1)
                ->groupBy('category.id')
                ->orderBy('questions.created_at', 'asc')
                ->get();
        print_r($query);
        die();
        return $query;*/
         /*return Category::select('category.*', 'coalesce(questions.id,0) as question_cnt')
          ->leftjoin('questions', 'category.id', '=', 'questions.category_id')
          ->where('category.record_status', 1)
          ->groupBy('category.id')
          ->orderBy('questions.created_at', 'asc')
          ->get(); */
        DB::statement(DB::raw('set @rownum=0'));
        if($admin_id>0){
            return group :: select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'groups.*'])->whereRecord_status(1)->where('admin_id',$admin_id)->orderBy('created_at', 'desc')->get();
        }else{
           return group :: select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'groups.*'])->whereRecord_status(1)->orderBy('created_at', 'desc')->get(); 
        }
        
         
    }

}
