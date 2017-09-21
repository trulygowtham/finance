<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserPostRequest extends Request {

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
        if (($this->segment(4)) != '') {
            $pageId = base64_decode($this->segment(4));
        }
        $this->rules = [
            'username' => 'required|unique:users,username,' . $pageId,
            'name' => 'required', 
            'email' => 'required|email', 
            'phone' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
        if ($this->route()->getName() == 'admin.users.add' || $this->route()->getName() == 'users.add') {
            $this->rules['confirm_password'] = 'required|same:password';
            $this->rules['password'] = 'required';
        }
        if ($this->route()->getName() == 'admin.users.edit' || $this->route()->getName() == 'users.edit') {
            if (isset($data['isChangePass']) && $data['isChangePass'] == 1) {
                $this->rules['confirm_password'] = 'required|same:password';
                $this->rules['password'] = 'required';
            }
        }
        return $this->rules;
    }

}
