<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'don_hangs';
    protected $fillable = [
        'ma_don_hang',
        'tong_tien_thanh_toan',
        'is_thanh_toan',
        'tinh_trang',
        'ho_va_ten',
        'so_dien_thoai',
        'dia_chi_giao_hang',
        'id_khach_hang',
    ];
}
