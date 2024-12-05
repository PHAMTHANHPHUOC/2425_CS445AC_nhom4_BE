<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinChuyenKhoan extends Model
{
    use HasFactory;
    protected $table = "thong_tin_chuyen_khoans";
    protected $fillable = [
        'ten_nguoi_nhan',
        'so_dien_thoai_nguoi_nhan',
        'link_qr_code',
        'is_active',
        'id_khach_hang',
    ];
}
