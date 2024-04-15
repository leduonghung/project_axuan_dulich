<?php
namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\RepositoryInterface;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getOne(int $id);

    // public function getAllPaginate();
}