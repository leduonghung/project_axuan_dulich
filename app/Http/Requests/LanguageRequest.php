<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
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
            'canonical' => 'required|string|unique:languages,canonical' . $id, // max 10000kb
            'name' => 'required|string', // max 10000kb
            // 'user_id' => 'required|integer', // max 10000kb
            // 'password' => 'required|string|min:6', // max 10000kb
            // 're_password' => 'required|string|same:password', // max 10000kb
        ];
    }
    public function messages() : array
    {
        // $id = request()->id ? ',' . request()->id : '';
        return [
            'canonical.unique' => ':attribute đã tồn tại', // max 10000kb
            'name.required' => 'Bạn chưa nhập :attribute',
            
        ];
    }
}
