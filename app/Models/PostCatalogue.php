<?php

namespace App\Models;

use App\Models\Language;
use App\Traits\QueryScopes;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCatalogue extends Model
{
    public function currentLanguage()  {
        return 1;
   }
    use HasFactory,SoftDeletes,QueryScopes;
    protected $table = 'post_catalogues';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
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
        return $this->belongsToMany(Language::class, 'post_catalogue_language', 'post_catalogue_id', 'language_id')
        ->withPivot(
            'post_catalogue_id', 
            'language_id',
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
    public function posts() {
        return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_id','post_catalogue_id');
    }
    public function post_catalogue_language() {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }
    public function post_language() {
        $base = new BaseService();
        return $this->hasOne(PostCatalogueLanguage::class, 'post_catalogue_id','id')->where('post_catalogue_language.language_id','=',$base->currentLanguage())->select(['id', 'name','post_catalogue_id','canonical']);
    }

    public static function isNodeCheck($id = 0){
        $postCatalogue = PostCatalogue::find($id);

        if($postCatalogue->rgt - $postCatalogue->lft !== 1){
            return false;
        } 

        return true;
        
    }

    public function routes()
    {
        return $this->hasOne(Router::class, 'module_id','id')->where('controllers', 'App\Http\Controllers\Frontend\PostCatalogueController')->withDefault([
            'controllers' => 'App\Http\Controllers\Frontend\PostCatalogueController',
        ]);
    }
}
