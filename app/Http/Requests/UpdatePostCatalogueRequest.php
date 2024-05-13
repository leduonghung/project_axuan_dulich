<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostCatalogueRequest extends FormRequest
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
        return config('apps.postCatalogue.fields');
    }
    public function rules()
    {
        // $id = request()->id ? ','.request()->id : '';
        // dd($this->id);
        return [
            'name' => 'required|string',
            'content' => 'required|string',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
            'parent_id' => 'required|integer',
            'post_catalogue_id' => 'unique:post_catalogue_language,post_catalogue_id,' . $this->id . ',id,language_id,' . $this->language_id,
            'canonical' => 'required|alpha_dash|max:255|unique:post_catalogue_language,canonical,' . $this->id.',post_catalogue_id',
            // 'slug' => 'required|integer',
        ];
    }
}
