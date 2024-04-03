<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface;

class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
    // protected $model;
    //lấy model tương ứng
    // public function __construct(PostCatalogue $PostCatalogue) {
    //     $this->model = $PostCatalogue;
    // }
    public function getModel()
    {
        return \App\Models\PostCatalogue::class;
    }
    public function pagination(
        array $columns = ['*'], 
        array $condition = [], 
        array $join = [], 
        array $extend =[],
        int $perPages = 15
        ) {
        $query =  $this->model->select($columns)
                ->where(function($query) use ($condition){
                    if(isset($condition['keyword']) && !empty($condition['keyword'])){
                        $query->where('name','LIKE', '%'.$condition['keyword'].'%');
                        // ->orWhere('email','LIKE', '%'.$condition['keyword'].'%')
                        // ->orWhere('phone','LIKE', '%'.$condition['keyword'].'%')
                        // ->orWhere('address','LIKE', '%'.$condition['keyword'].'%')
                        // ->orWhere('phone','LIKE', '%'.$condition['keyword'].'%');
                    }
                 });
        if(!empty($join)) $query->join(...$join);
        $query->orderBy('id', 'desc');
        $data['postCatalogues'] =  $query->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
        $data['softDeletes'] =  $query->onlyTrashed()->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
        return $data;
    }
}
