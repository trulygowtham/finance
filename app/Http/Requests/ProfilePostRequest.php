<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfilePostRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $pageId = '';
        $data = $this->all();

        if (($this->segment(3)) != '') {
            $pageId = base64_decode($this->segment(3));
        }
        $this->rules = [

            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
        if (isset($data['isChangePass']) && $data['isChangePass'] == 1) {
            $this->rules['confirm_password'] = 'required|same:password';
            $this->rules['password'] = 'required';
        }
        return $this->rules;
    }

}
