<?php

namespace App\Models;

// use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    
    protected $table = 'provinces';
    protected $primaryKey  = 'code';
    public $incrementing = false;
    
    // In Laravel 6.0+ make sure to also set $keyType
    // protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class,'province_code','code');
    }
}
