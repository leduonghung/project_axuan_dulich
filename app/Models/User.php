<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_catalogue_id',
        'status',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'birthday',
        'image',
        'description',
        'user_agent',
        'ip',
        'userCreated',
        'userUpdated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isActive()
    {
        return ($this->status) ? 'Kích hoạt' : ' &nbsp; Ẩn &nbsp; ';
    }

    public function userCre()
    {
        return $this->hasOne('App\Models\User', 'id', 'userCreated');
    }
    public function userUp()
    {
        return $this->hasOne('App\Models\User', 'id', 'userUpdated');
    }
}
