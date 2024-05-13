<?php

namespace App\Models;

use App\Models\Language;
use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,SoftDeletes,QueryScopes;
    protected $table = 'posts';
    // protected $primaryKey = 'id';
    
    protected $fillable = [
        'post_catalogue_id',
        'image',
        'album',
        'follow',
        'publish',
        'order',
        'userCreated',
        'userUpdated'
    ];
    
    public function isActive()
    {
        return ($this->publish) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'post_language', 'post_id', 'language_id')
        ->withPivot(
            // 'post_id',
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical',
            'userCreated'
            )
        ->withTimestamps();
    }
    public function post_catalogues() {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_post','post_id', 'post_catalogue_id');
    }
    public function catalogue() {
        return $this->hasOne(PostCatalogue::class,'id', 'post_catalogue_id')->select(['id', 'image','publish']);
    }
    public function post_language() {
        return $this->hasOne(PostLanguage::class, 'post_id');
    }

    public function routes()
    {
        return $this->hasOne(Router::class, 'module_id','id')->where('controllers', 'App\Http\Controllers\Frontend\PostController')->withDefault([
            'controllers' => 'App\Http\Controllers\Frontend\PostController',
        ]);
    }
    
}
