<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QuestionPostRequest extends Request
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
        
        return [            
            'category_id' => 'required',
            'name' => 'required',
            'option_type' => 'required'            
        ];
    }
}
