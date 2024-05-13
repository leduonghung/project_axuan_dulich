<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Arr;

abstract class BaseRepository implements BaseRepositoryInterface
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
        int $perPages = 15,
        array $extend =[],
        array $orderBy =[['id','DESC']],
        array $join = [], 
        array $relations =[],
        array $rawQuery = []
        ) {
            $query =  $this->model->select($columns);
            return $query
                ->keyword($condition['keyword'] ?? null)
                ->publish($condition['publish'] ?? null)
                ->customWhere($condition['where'] ?? null)
                ->customWhereRaw($rawQuery['whereRaw'] ?? null)
                ->relationCount($relations?? null)
                ->relation($relations?? null)
                ->customjoin($join ?? null)
                ->customGroupBy($extend['groupBy'] ?? null)
                ->customOrderBy($orderBy)
                ->paginate($perPages)->withQueryString()->withPath(env('APP_URL').$extend['path']);
    }

    public function getAllPaginate($perPages = 5)
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPages);
    }

    public function getAll(array $columns = ['*'])
    {
        return $this->model->select($columns)->get();
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
        // dd($this->model);
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

    public function createPivot($model, array $attributes =[], string $relation ='') {
        return $model->{$relation}()->attach($model->id,$attributes);
    }
}