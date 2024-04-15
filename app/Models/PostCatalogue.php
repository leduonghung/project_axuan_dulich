<?php

namespace App\Models;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCatalogue extends Model
{
    use HasFactory,SoftDeletes;
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
            // 'post_catalogue_id', 
            // 'language_id',
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
    public function post_catalogue_language() {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }
}
