<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    // protected $model;
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Post::class;
    }
    public function getPostById(int $id = 0, $language_id = 0){
        return $this->model->select([
            'posts.id',
            'posts.post_catalogue_id',
            'posts.image',
            'posts.icon',
            'posts.album',
            'posts.publish',
            'posts.follow',
            'posts.order',
            'tb2.id as id_lang',
            'tb2.name',
            'tb2.description',
            'tb2.content',
            'tb2.meta_title',
            'tb2.canonical',
            'tb2.meta_keyword',
            'tb2.meta_description',
            ])
            ->join('post_language as tb2', 'tb2.post_id','=','posts.id')
            ->with('post_language')
            ->where('tb2.language_id','=',$language_id)
            ->findOrFail($id);
    }
}
