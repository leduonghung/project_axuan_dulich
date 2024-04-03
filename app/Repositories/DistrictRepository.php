<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\District::class;
    }

    // public function findDistrictByProvinceId($province_id)
    // {
    //     return $this->model->select('code','full_name')->where('province_code', $province_id)->get();
    // }
}
