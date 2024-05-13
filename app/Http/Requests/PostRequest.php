<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        // dd(Lang::get('messages.post.fields'));
        return Lang::get('messages.post.fields');
        
    }
    public function rules()
    {
        // $id = request()->id ? ','.request()->id.',post_id' : '';
        $id = request()->id ? ',' . Post::find(request()->id)->post_language->id: null;
        
        return [
            'name' => 'required|string',
            'content' => 'required|string',
            'post_catalogue_id' => 'required|gt:0',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
            // 'canonical' => 'required|alpha_dash|max:255|unique:post_language,canonical' . $id,
            'canonical' => 'required|alpha_dash|max:255|unique:post_language,canonical' . $id, // max 10000kb
        ];
    }

    public function messages() : array
    {
        return [
            'canonical.unique' => ':attribute đã tồn tại',
            'canonical.alpha_dash' => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
            'name.required' => 'Bạn chưa nhập :attribute',
            'content.required' => 'Bạn chưa nhập :attribute',
            'post_catalogue_id.required' => 'Bạn chưa nhập :attribute',
            'post_catalogue_id.gt' => 'Bạn chưa nhập :attribute',
            
        ];
    }
}
