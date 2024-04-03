<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',

        ];
    }

    public function rules()
    {
        // $id = request()->id ? ',' . request()->id : '';
        return [
            // 'email' => 'unique:connection.users,email_address'
            // 'status' => 'integer',
            //'order' => 'numeric|min:2|max:5|nullable',
            // 'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            'email' => 'required|email', // max 10000kb
            // 'email' => 'required|email|unique:users,email,' .$this->get('id'), // max 10000kb
            'password' => 'required', // max 10000kb
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Bạn chưa nhập :attribute',
            'email.email' => ':attribute chưa đúng định dạng',
            'password.required' => 'Bạn chưa nhập :attribute',
        ];
    }
}
