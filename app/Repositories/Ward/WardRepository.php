<?php
namespace App\Repositories\Ward;

use App\Repositories\BaseRepository;
use App\Repositories\Ward\Interfaces\WardRepositoryInterface;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Ward::class;
    }

    public function getWard()
    {
        return $this->model->take(5)->get();
    }
}
