<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    // public function getUser()
    // {
    //     return $this->model->take(5)->get();
    // }
    
    public function pagination(
        array $columns = ['*'], 
        array $condition = [], 
        int $perPages = 15,
        array $extend =[],
        array $orderBy =[['id','DESC']],
        array $join = [], 
        array $relations =[]
        ) {
        $query =  $this->model->select($columns)
                ->where(function($query) use ($condition){
                    if(isset($condition['keyword']) && !empty($condition['keyword'])){
                        $query->where('name','LIKE', '%'.$condition['keyword'].'%')
                        ->orWhere('email','LIKE', '%'.$condition['keyword'].'%')
                        // ->orWhere('phone','LIKE', '%'.$condition['keyword'].'%')
                        ->orWhere('address','LIKE', '%'.$condition['keyword'].'%')
                        ->orWhere('phone','LIKE', '%'.$condition['keyword'].'%');
                    }
                 });
        if(!empty($join)) $query->join(...$join);
        $query->orderBy('id', 'desc');
        $data['users'] =  $query->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
        $data['SoftDeletes'] =  $query->onlyTrashed()->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
        return $data;
    }
    
}
