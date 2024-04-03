<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Province::class;
    }

    public function getAll()
    {
        return $this->model->select('code','full_name')->orderBy('name','ASC')->get();
    }
    public function getOne(int $id)
    {
        return $this->model->select('code','full_name')
        ->with('districts:province_code,code,full_name')
        ->findOrFail($id);
    }
}
