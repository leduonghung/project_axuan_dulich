<?php
namespace App\Repositories\Ward\Interfaces;

use App\Repositories\Interfaces\RepositoryInterface;

interface WardRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getWard();

    public function getAllPaginate();
}