<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
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
        $id = request()->id ? ','.request()->id : '';
        dd($id);
        return [
            'name' => 'required|string',
            'content' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
            'parent_id' => 'required|integer',
            'canonical' => 'required|alpha_dash|max:255|unique:post_catalogue_language,canonical' . $id,
            // 'slug' => 'required|integer',
            //'order' => 'numeric|min:2|max:5|nullable',
            // 'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            // 'canonical' => 'required|string|unique:post_catalogue_language,canonical' . $id,
            // 'canonical' => "required|alpha_dash|unique:post_catalogue_language,canonical" .$id,
            // 'canonical' => 'required|string|unique:post_catalogue_language,canonical' . $id, // max 10000kb
            // 'user_id' => 'required|integer',
        ];
    }
    public function messages() : array
    {
        return [
            'canonical.unique' => ':attribute đã tồn tại',
            'name.required' => 'Bạn chưa nhập :attribute',
            'parent_id.gt' => 'Bạn chưa nhập Danh mục cha',
            
        ];
    }
}
