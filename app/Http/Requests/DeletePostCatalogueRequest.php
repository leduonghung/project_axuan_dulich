<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckPostCatalogueChildrenRule;

class DeletePostCatalogueRequest extends FormRequest
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
        return [
            'name'=>'Danh mục'
        ];
    }
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            // 'name'=> ['required', new CheckPostCatalogueChildrenRule($id) ],
            'name'=> [ new CheckPostCatalogueChildrenRule($id) ],
            
        ];
    }
}
