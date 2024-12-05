<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NapTien extends Model
{
    use HasFactory;
    protected $table = "nap_tiens";
    protected $fillable = [
        'thanh_tien',
        'is_active',
        'pin_active',
        'id_khach_hang',
    ];
}
