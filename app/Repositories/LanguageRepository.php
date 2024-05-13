<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    // protected $model;
    //lấy model tương ứng
    // public function __construct(Language $language) {
    //     $this->model = $language;
    // }
    public function getModel()
    {
        return \App\Models\Language::class;
    }
    // public function pagination(
    //     return $this->model->getAll();
    // }

    public function updateLanguage($id){
        $this->update($id,['current'=>1]);
        return $this->model->where('id','!=',$id)->where('current',1)->update(['current'=>0]);
    }
}
