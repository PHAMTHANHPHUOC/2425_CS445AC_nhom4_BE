<?php

namespace App\Http\Controllers;

use App\Models\ThongTinChuyenKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThongTinChuyenKhoanController extends Controller
{
    public function getData()
    {
        $user = Auth::guard('sanctum')->user();
        $data   = ThongTinChuyenKhoan::where('id_khach_hang', $user->id)->first();
        return response()->json([
            'data'  =>  $data
        ]);
    }
}
