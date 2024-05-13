<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Router extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'routers';
    
    // In Laravel 6.0+ make sure to also set $keyType
    // protected $keyType = 'string';

    protected $fillable = [
        'canonical',
        'module_id',
        'controllers',
        'userCreated',
        'userUpdated'
    ];

    public function pótCataloge()
    {
        return $this->PostCatalogue(Router::class,'id', 'module_id')->where('routers.controllers', 'App\Http\Controllers\Frontend\PostCatalogueController');
    }
}
