<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapNhapKhachHangRequest;
use App\Http\Requests\DoiMatKhauKhachHangRequest;
use App\Http\Requests\DoiMatKhaurRequest;
use App\Http\Requests\LayLaiMatKhauRequest;
use App\Http\Requests\ThemMoiKhachHangRequest;
use App\Mail\KichHoatKhachHang;
use App\Mail\QuenMatKhau;
use App\Mail\QuenMatKhauKhachHang;
use App\Models\DonHang;
use App\Models\GiaoDich;
use App\Models\KhachHang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Str;


class KhachHangController extends Controller
{
    public function kiemTraChiaKhoaKhachHang()
    {

         $khach_hang  = $this->isUserKhachHang();

        if($khach_hang) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }
    public function store(ThemMoiKhachHangRequest $request)
    {

        $tai_khoan = KhachHang::create([
            'email'             => $request->email,
            'so_dien_thoai'     => $request->so_dien_thoai,
            'ho_va_ten'         => $request->ho_va_ten,
            'password'          => bcrypt($request->password),
            'hash_active'       => Str::uuid(),
        ]);

        Mail::to($request->email)->send(new KichHoatKhachHang($tai_khoan->hash_active, $request->ho_va_ten));

        return response()->json([
            'status' => true,
            'message' => "Đăng Kí Tài Khoản Thành Công!"
        ]);
    }

    public function actionLogin(Request $request)
    {
        $check  = Auth::guard('khach_hang')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);
        if ($check) {
            $user   =   Auth::guard('khach_hang')->user();
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
    public function kichHoatTaiKhoan($hash_active)
    {
        $tai_khoan = KhachHang::where('hash_active', $hash_active)->where('is_active', 0)->first();

        if($tai_khoan) {
            $tai_khoan->is_active = 1;
            $tai_khoan->hash_active = null;
            $tai_khoan->save();

            return response()->json([
                'status' => true,
                'message' => "Bạn đã kích hoạt tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Tài khoản bạn đã được kích hoạt hoặc không tồn tại!"
            ]);
        }
    }
    public function actionQuenmatKhau(Request $request)
    {
        try {
            $quenMK = KhachHang::where('email', $request->email)->first();

            if ($quenMK) {
                $quenMK->hash_reset = Str::uuid();
                $quenMK->save();
                Mail::to($request->email)->send(new QuenMatKhau($quenMK->hash_reset, $quenMK->ho_va_ten));
            }
            return response()->json([
                'status' => true,
                'message' => "Kiểm tra email của bạn !!!"
            ]);
        } catch (Exception) {
            return response()->json([
                'status' => false,
                'message' => "Đã có lỗi xảy ra!"
            ]);
        }
    }
    public function actionLayLaiMatKhau($hash_reset, LayLaiMatKhauRequest $request)
    {
        $khach_hang = KhachHang::where('hash_reset', $hash_reset)->first();
        if ($khach_hang) {
            $khach_hang->password = bcrypt($request->password);
            $khach_hang->hash_reset = null;
            $khach_hang->save();
            return response()->json([
                'status' => true,
                'message' => "Mật khẩu đã được thay đổi"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Đã có lỗi xảy ra!"
            ]);
        }
    }
    public function thongTin()
    {
        $khach_hang = Auth::guard('sanctum')->user();

        return response()->json([
            'data' => $khach_hang
        ]);
    }
    public function dangXuat()
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if($khach_hang){
            DB::table('personal_access_tokens')
              ->where('id', $khach_hang->currentAccessToken()->id)->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đăng xuất thiết bị này thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }
    public function dangXuatALL()
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if ($khach_hang) {
            $ds_token = $khach_hang->tokens;
            foreach ($ds_token as $k => $v) {
                if($v->tokenable_type == "App\Models\KhachHang"){
                    $v->delete();
                }
            }
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


    public function updateThongTin(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();

        if ($khach_hang) {
            KhachHang::where('id', $khach_hang->id)->update([
                'email'             => $request->email,
                'so_dien_thoai'     => $request->so_dien_thoai,
                'ho_va_ten'         => $request->ho_va_ten,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Bạn đã cập nhật thông tin thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function updateMatKhau(LayLaiMatKhauRequest $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        // return response()->json($khach_hang);
        if ($khach_hang) {
            KhachHang::where('id', $khach_hang->id)->update([
                'password'             => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => "Bạn đã cập nhật mật khẩu thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
    // public function kichHoatTaiKhoanKh(Request $request)
    // {
    //     $khach_hang = KhachHang::where('id', $request->id)->first();

    //     if ($khach_hang) {
    //         if ($khach_hang->is_active == 0) {
    //             $khach_hang->is_active = 1;
    //             $khach_hang->save();
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => "Đã kích hoạt tài khoản thành công!"
    //             ]);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => "Có lỗi xảy ra!"
    //         ]);
    //     }
    // }
    public function dataKhachHang()
    {

        $data = KhachHang::get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function doiTrangThaiKhachHang(Request $request)
    {
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->is_block = !$khach_hang->is_block;
            $khach_hang->save();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
    public function updateTaiKhoan(CapNhapKhachHangRequest $request)
    {
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->update([
                'email'             => $request->email,
                'so_dien_thoai'     => $request->so_dien_thoai,
                'ho_va_ten'         => $request->ho_va_ten,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
    public function deleteTaiKhoan(Request $request)
    {
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function doiMatKhauTaiKhoan(DoiMatKhaurRequest $request)
    {

        $user = Auth::guard('sanctum')->user();
        $khach_hang = KhachHang::where('id', $request->id)->first();
        if ($khach_hang) {
            $khach_hang->update([
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => "Đã đổi mật khẩu tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }
    public function doiMatKhauKhachHang(DoiMatKhaurRequest $request)
    {

        $khach_hang = Auth::guard('sanctum')->user();

        if ($khach_hang) {
            KhachHang::where('id', $khach_hang->id)->update([
                'password' => bcrypt($request->password),

            ]);

            return response()->json([
                'status' => true,
                'message' => "Đã đổi mật khẩu tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function hoaDon(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if ($khach_hang) {
            $donHang = DonHang::find('id' , $request->id);
            $giaoDich = GiaoDich::where('description', 'like', '%Thanh toán đơn hàng%')
                ->where('pos', $donHang->ma_don_hang)
                ->first();
        }




        // // Truy vấn để lấy thông tin đơn hàng cụ thể
        // $donHang = DonHang::find($idDonHang);

        // if (!$donHang) {
        //     // Xử lý trường hợp không tìm thấy đơn hàng
        //     return response()->json(['error' => 'Không tìm thấy đơn hàng'], 404);
        // }
        // // Truy vấn để lấy thông tin khách hàng của đơn hàng
        // $khachHang = KhachHang::find($donHang->id_khach_hang);
        // // Truy vấn để lấy thông tin giao dịch (thanh toán) của đơn hàng
        // $giaoDich = GiaoDich::where('description', 'like', '%Thanh toán đơn hàng%')
        //             ->where('pos', $donHang->ma_don_hang)
        //             ->first();
        // if (!$giaoDich) {
        //     // Xử lý trường hợp không tìm thấy thông tin thanh toán
        //     return response()->json(['error' => 'Không tìm thấy thông tin thanh toán'], 404);
        // }
        // // Tạo một mảng chứa dữ liệu của hóa đơn để trả về
        // $hoaDon = [
        //     'don_hang' => $donHang,
        //     'khach_hang' => $khachHang,
        //     'giao_dich' => $giaoDich
        // ];
        // // Trả về dữ liệu hóa đơn
        // return response()->json($hoaDon);
    }
}
