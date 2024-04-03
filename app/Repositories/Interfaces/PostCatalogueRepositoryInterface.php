<?php
namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\RepositoryInterface;

interface PostCatalogueRepositoryInterface extends RepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    // public function getLanguage();

    // public function getAllPaginate();
    public function pagination();
}