<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Admin extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;


    protected $table = "admins";
    protected $fillable = [
        'email',
        'so_dien_thoai',
        'ho_va_ten',
        'password',
        'hash_reset',
        'hash_active',
        'is_active',
        'is_block',
        'tong_tien'
    ];
}
