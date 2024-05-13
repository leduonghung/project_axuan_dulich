<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory,SoftDeletes,QueryScopes;
    protected $table = 'languages';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'canonical',
        'image',
        'flag',
        'current',
        'user_id',
        'publish',
        'userCreated',
        // 'userUpdated'
    ];

    public function isActive()
    {
        return ($this->publish) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }

    public function post_catalogue(){
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
        // ->withPivot('name','description','content','meta_title','meta_keyword','meta_description','canonical')
        ->withTimestamps();
    }

    // public function post_catalogue_language()
    // {
    //     return $this->belongsToMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    // }
}
