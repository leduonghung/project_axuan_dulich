<?php

namespace App\Rules;

use Closure;
use App\Models\PostCatalogue;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckPostCatalogueChildrenRule implements ValidationRule
{
    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }
    public $implicit = true;
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $flag = PostCatalogue::isNodeCheck($this->id);
        if ($flag == false) {
            $fail('Bạn không thể xóa :attribute do vẫn còn danh mục con');
        }
    }

   

    public function message(){
        return 'The :attribute must match with' . $this->id . '.';
    }
}
