<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCatalogueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return config('apps.postCatalogue.fields');
    }
    public function rules()
    {
        $id = request()->id ? ',' . request()->id : '';
        return [
            'name' => 'required|string', // max 10000kb
            'content' => 'required|string', // max 10000kb
            'meta_title' => 'required|string', // max 10000kb
            'meta_description' => 'required|string', // max 10000kb
            'user_catalogue_id' => 'gt:0',
            //'order' => 'numeric|min:2|max:5|nullable',
            // 'fullname' => 'required|string' .$this->get('id'), // max 10000kb
            // 'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            'canonical' => 'required|string|unique:post_catalogues,canonical' . $id, // max 10000kb
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
            'user_catalogue_id.gt' => 'Bạn chưa nhập Danh mục cha',
            
        ];
    }
}
