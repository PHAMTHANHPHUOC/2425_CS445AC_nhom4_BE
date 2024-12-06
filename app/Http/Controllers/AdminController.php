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
    public function actionLogin(Request $request)
    {
        $check  = Auth::guard('Admin')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);
        if ($check) {
            $user   =   Auth::guard('Admin')->user();
            if ($user->is_active == 0) {
                return response()->json([
                    'message'  =>   'Tài khoản của bạn chưa được kích hoạt!',
                    'status'   =>   2
                ]);
            } else {
                if ($user->is_block) {
                    return response()->json([
                        'message'  =>   'Tài khoản của bạn đã bị khóa!',
                        'status'   =>   0
                    ]);
                }

                return response()->json([
                    'message'   =>   'Đã đăng nhập thành công!',
                    'status'    =>   1,
                    'chia_khoa' =>   $user->createToken('ma_so_bi_mat_khach_hang')->plainTextToken,
                ]);
            }
        } else {
            return response()->json([
                'message'  =>   'Tài khoản hoặc mật khẩu không đúng!',
                'status'   =>   0
            ]);
        }
    }
    public function thongTin()
    {
        $admin = Auth::guard('sanctum')->user();

        return response()->json([
            'data' => $admin
        ]);
    }
    public function dangxuat()
    {
        $admin = Auth::guard('sanctum')->user();
        if ($admin) {
            DB::table('personal_access_tokens')
                ->where('id', $admin->currentAccessToken()->id)->delete();
            return response()->json([
                'status' => true,
                'message' => "Đã Đăng Xuất Thiết Bị Thành Công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }
    public function kiemTraChiaKhoaAdmin()
    {
        $admin  = $this->isUserAdmin();

        if ($admin) {
            return response()->json([
                'status'   =>   true,
                'message'  =>   'Ok, bạn có thể đi qua!',
            ]);
        } else {
            return response()->json([
                'status'   =>   false,
                'message'  =>   'Bạn chưa đăng nhập tài khoản!',
            ]);
        }
    }
}
