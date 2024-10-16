<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id_user'; 
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product');
    }

    public function salesquotation()
    {
        return $this->hasMany(Product::class, 'id_sales');
    }

}
