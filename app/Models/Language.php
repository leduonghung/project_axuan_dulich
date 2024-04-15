<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'languages';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'canonical',
        'image',
        'user_id',
        'status',
        'userCreated',
        // 'userUpdated'
    ];

    public function isActive()
    {
        return ($this->status) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }

    public function postCatalogue(){
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
        ->withPivot('name','description','content','meta_title','meta_keyword','meta_description','canonical')
        ->withTimestamps();
    }
}
