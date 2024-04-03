<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    protected $model;

   //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
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
                    }
                 });
        if(!empty($join)) $query->join(...$join);
        return $query->orderBy('id', 'desc')->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
    }

    public function getAllPaginate($perPages = 5)
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPages);
    }

    public function getAll()
    {
        return $this->model->get();
    }
    

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function findById(int $id, array $columns = ['*'], array $relation = [])
    {
        $result = $this->model->select($columns)->with($relation)->findOrFail($id);

        return $result;
    }

    public function findWhere(array $collectWhere, array $columns = ['*'], array $relation = [])
    {
        return $this->model->select($columns)->with($relation)->where($collectWhere)->first();
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }
   
    public function updateByWhereIn(array $whereIn = [], $attributes = [])
    {
        $result = $this->model->whereIn('id',$whereIn)->update($attributes);
        if ($result) {
            return $this->find($whereIn);
        }

        return false;
    }
   

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}