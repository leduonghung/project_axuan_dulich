<?php

namespace App\Models;

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
        'public',
        'order',
        'userCreated',
        'userUpdated'
    ];
    
    public function isActive()
    {
        return ($this->status) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }
}
