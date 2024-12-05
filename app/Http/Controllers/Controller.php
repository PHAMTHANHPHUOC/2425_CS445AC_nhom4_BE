<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function isUserKhachHang()
    {
        $khach_hang = Auth::guard('sanctum')->user();

        if ($khach_hang instanceof \App\Models\KhachHang) {
            return $khach_hang;
        }
        return false;
    }
    public function isUserAdmin()
    {
        $admin = Auth::guard('sanctum')->user();

        if ($admin instanceof \App\Models\Admin) {
            return $admin;
        }
        return false;
    }
}
