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
        $id = request()->id ? ','.$this->id.',module_id': '';
        // $id = request()->id ? ','.request()->id.',post_catalogue_id' : '';
        // $id = request()->id ? ','.request()->id.',id' : '';
        // dd($id);
        return [
            'name' => 'required|string',
            'content' => 'required|string',
            'meta_title' => 'required|string',
            'description' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
            'parent_id' => 'required|integer',
            'canonical' => 'required|unique:routers,canonical'.$id,
            // 'canonical' => 'required|alpha_dash|max:255|unique:routers,canonical' . $id,
            // 'canonical' => 'required|unique:routers,canonical,' . $this->id . ',id,module_id,' . $this->module_id . ',controllers,' . $this->controllers,
            // 'canonical' => 'required|alpha_dash|max:255|unique:post_catalogue_language,canonical,' . $this->id.',post_catalogue_id',
            
        ];
    }
    public function messages() : array
    {
        return [
            'canonical.unique' => ':attribute đã tồn tại',
            'canonical.alpha_dash' => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
            'name.required' => 'Bạn chưa nhập :attribute',
            'parent_id.gt' => 'Bạn chưa nhập Danh mục cha',
            
        ];
    }
}
