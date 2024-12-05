<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuDo extends Model
{
    use HasFactory;

    protected $table = "tu_dos";
    protected $fillable = [
        'ten_san_pham',
        'hinh_anh',
        'gia_ban',
        'is_active',
        'has_active',
        'pin_active',
        'id_khach_hang',

    ];
}
