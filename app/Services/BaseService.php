<?php

namespace App\Services;

use DB, Log;
use App\Classes\Nestedsetbie;
use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface as BaseRepository;

class BaseService implements BaseServiceInterface
{
    protected $nestedset;
    public function __construct()
    {
    }

    public function currentLanguage()
    {
        return 1;
    }

    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    public function formatRouterPayload($model_id,$canonical, $controllerName){
        return [
            'canonical' =>$canonical,
            'module_id' =>$model_id,
            'controllers'=>'App\Http\Controllers\Frontend\\'.$controllerName
        ];
    }
}
