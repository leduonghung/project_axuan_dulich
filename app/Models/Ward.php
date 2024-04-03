<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;
    
    protected $table = 'wards';
    protected $primaryKey  = 'code';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'name_en',
    ];
    
    public function district(): BelongsTo
    {
        return $this->BelongsTo(District::class,'district_code');
    }
}
