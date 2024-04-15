<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface as BaseRepository;
use DB,Log;

class BaseService implements BaseServiceInterface
{

    public function __construct() {
    }

    public function currentLanguage()  {
        return 1;
   }
}
