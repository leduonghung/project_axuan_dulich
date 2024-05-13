<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostLanguage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'post_language';
    // protected $primaryKey = 'id';
    
    protected $fillable = [
        'post_id',
        'language_id',
        'name',
        'description',
        'content',
        'meta_title',
        'canonical',
        'meta_keyword',
        'meta_description',
        'userCreated',
        'userUpdated',
    ];
    
    public function isActive()
    {
        return ($this->publish) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }

    
    // public function post_catalogues() {
    //     return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_post', 'post_catalogue_id','post_id');
    // }
    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
