<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Role extends Model {

    protected $table = 'roles';
    protected $fillable = ['name','created_by'];
 
}
