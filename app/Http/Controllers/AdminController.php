<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemMoiAdminRequest;
use App\Models\Admin;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function store(ThemMoiAdminRequest $request)
    {

        $tai_khoan = Admin::create([
            'email'             => $request->email,
            'so_dien_thoai'     => $request->so_dien_thoai,
            'ho_va_ten'         => $request->ho_va_ten,
            'password'          => bcrypt($request->password),
            'hash_active'       => Str::uuid(),
        ]);


        return response()->json([
            'status' => true,
            'message' => "Đăng Kí Tài Khoản Thành Công!"
        ]);
    }
   
}
