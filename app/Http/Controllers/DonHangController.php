<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ThongTinChuyenKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class DonHangController extends Controller
{
    public function data(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $data = DonHang::where('id_khach_hang' , $khach_hang->id)->get();
        return response()->json([
            'data'  =>  $data
        ]);

    }

    public function acTionNapTien(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();

        if($khach_hang)
        {
            $don_hang = DonHang::where('id_khach_hang',  $khach_hang->id)
                                   ->where('is_thanh_toan', 0)
                                   ->where('tong_tien_thanh_toan', 0)
                                   ->orderByDESC('id')
                                   ->first();

            if(!$don_hang) {
                $don_hang = DonHang::create([
                    'ma_don_hang'               => "",
                    'tong_tien_thanh_toan'      => $khach_hang->tong_tien,
                    'is_thanh_toan'             => 0,   //Khong cần viết dòng nãy cũng được
                    'tinh_trang'                => 0,   //Khong cần viết dòng nãy cũng được
                    'ho_va_ten'                 => $khach_hang->ho_va_ten,
                    'so_dien_thoai'             => $khach_hang->so_dien_thoai,
                    'dia_chi_giao_hang'         => "Đà Nẵng",   //Khong cần viết dòng nãy cũng được
                    'id_khach_hang'             => $khach_hang->id
                ]);
                $ma_don_hang = "PTP" . (151203 + $don_hang->id);
                $don_hang->ma_don_hang = $ma_don_hang;
                $don_hang->save();
            }

            $link   =   "https://img.vietqr.io/image/MB-0347941497-print.png?amount="."&addInfo=" . $don_hang->ma_don_hang;

            $nap_tien                                   = ThongTinChuyenKhoan::where('id_khach_hang',$khach_hang->id)->first();
            if($nap_tien) {
                $nap_tien->ten_nguoi_nhan               = $khach_hang->ho_va_ten;
                $nap_tien->so_dien_thoai_nguoi_nhan     = $khach_hang->so_dien_thoai;
                $nap_tien->link_qr_code                 = $link;
                $nap_tien->save();
            } else {
                ThongTinChuyenKhoan::create([
                    'ten_nguoi_nhan'                => $khach_hang->ho_va_ten,
                    'so_dien_thoai_nguoi_nhan'      => $khach_hang->so_dien_thoai,
                    'link_qr_code'                  => $link,
                    'id_khach_hang'                 => $khach_hang->id,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => "Mời Bạn Thanh Toán"
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => "Đã Có Lỗi"
            ]);
        }
    }


}
