<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface;

class RouterRepository extends BaseRepository implements RouterRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Router::class;
    }
}
