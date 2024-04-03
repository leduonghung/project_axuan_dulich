<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return config('apps.user.fields');
    }
    public function rules()
    {
        $id = request()->id ? ',' . request()->id : '';
        return [
            // 'status' => 'integer',
            //'order' => 'numeric|min:2|max:5|nullable',
            // 'fullname' => 'required|string' .$this->get('id'), // max 10000kb
            // 'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            'email' => 'required|email|string|max:191|unique:users,email' . $id, // max 10000kb
            'name' => 'required|string', // max 10000kb
            'password' => 'required|string|min:6', // max 10000kb
            're_password' => 'required|string|same:password', // max 10000kb
        ];
    }
    public function messages() : array
    {
        // $id = request()->id ? ',' . request()->id : '';
        return [
            'email.required' => 'Bạn chưa nhập :attribute', // max 10000kb
            'email.email' => ':attribute không đúng định dạng', // max 10000kb
            'email.unique' => ':attribute đã tồn tại', // max 10000kb
            'name.required' => 'Bạn chưa nhập :attribute',
            'password.required' => 'Bạn chưa nhập :attribute',
            're_password.required' => 'Bạn chưa nhập :attribute',
            're_password.same' => ':attribute không khớp với mật khẩu', // max 10000kb
        ];
    }
   
}
