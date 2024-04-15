<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCatalogueLanguage extends Model
{
    use HasFactory;
    protected $table = 'post_catalogue_language';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'post_catalogue_id',
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

    
    public function post_catalogues()
    {
        return $this->belongsTo(PostCatalogue::class, 'post_catalogue_id', 'id');
    }
}
