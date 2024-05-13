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
    public function getPostCatalogueById(int $id = 0, $language_id = 0){
        return $this->model->select([
            'post_catalogues.id',
            'post_catalogues.parent_id',
            'post_catalogues.image',
            'post_catalogues.icon',
            'post_catalogues.album',
            'post_catalogues.publish',
            'post_catalogues.follow',
            'post_catalogues.order',
            'tb2.id as id_cate_lang',
            'tb2.name',
            'tb2.description',
            'tb2.content',
            'tb2.meta_title',
            'tb2.canonical',
            'tb2.meta_keyword',
            'tb2.meta_description',
            ])
            ->join('post_catalogue_language as tb2', 'tb2.post_catalogue_id','=','post_catalogues.id')
            // ->where('post_catalogues.id','=',$id)
            ->where('tb2.language_id','=',$language_id)
            ->findOrFail($id);
    }

}
