<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    
    protected $table = 'districts';
    protected $primaryKey  = 'code';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'full_name',
        'province_code',
    ];

    public function province(): BelongsTo
    {
        return $this->BelongsTo(Province::class,'province_code','code');
    }

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class,'district_code','code');
    }
}
