<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\NapTien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NapTienController extends Controller
{
    // public function keyChuyenKhoan(Request $request)
    // {
    //     $khach_hang = Auth::guard('sanctum')->user();
    //     $nap_tien = NapTien::where('id', $request->id)->where('id_khach_hang', $khach_hang->id)->first();
    //     if($nap_tien) {
    //         $nap_tien->update([
    //             'thanh_tien' => $request->thanh_tien,
    //             'hash_active' => $request->hash_active,
    //         ]);

    //         $user = KhachHang::find($khach_hang->id);
    //         $user->tong_tien = $user->tong_tien +  $request->thanh_tien;
    //         $user->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => "Thanh toán thành công!" ,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => "Đã có lỗi xảy ra!" ,
    //         ]);
    //     }
    // }

    // public function taoNapTien()
    // {
    //     $khach_hang = Auth::guard('sanctum')->user();

    //     // return response()->json($khach_hang);
    //     $pin_hash = rand(100000, 999999);

    //     $check = NapTien::where('id_khach_hang', $khach_hang->id)->where('is_active', 0)->whereNull('thanh_tien')->first();
    //     if($check) {
    //         return response()->json([
    //             'data' => $check
    //         ]);
    //     }

    //     $napTien = NapTien::create([
    //         'id_khach_hang' => $khach_hang->id,
    //         'pin_active'    => $pin_hash
    //     ]);

    //     return response()->json([
    //         'data' => $napTien
    //     ]);

    // }
    public function napTien(Request $request)
    {
        $khach_hang = Auth::guard('sanctum')->user();
    }
}
