<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Session;

class GroupPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $catId = '';

        if (($this->segment(3))!='') {
            $catId = base64_decode($this->segment(3));
           
        } 
        
        $session_data = Session::all(); 
        $admin_id = $session_data['admin_id'];
        
        return [
            'name' => "required|unique:groups,name,$catId,id,admin_id,$admin_id", 
        ];
    }
}
