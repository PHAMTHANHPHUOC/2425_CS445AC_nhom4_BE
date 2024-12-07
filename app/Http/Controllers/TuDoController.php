<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CreateTuDorequest;
    use App\Models\GiaoDich;
    use App\Models\KhachHang;
    use App\Models\TuDo;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;
  

    class TuDoController extends Controller
    {
        public function update(Request $request)
        {
            $data = TuDo::where('id', $request->id)->first();
            if ($data) {
                $data->update([
                    'ten_san_pham'   => $request->ten_san_pham,
                    'hinh_anh'       => $request->hinh_anh,
                    'gia_ban'        => $request->gia_ban,
                    'is_active'      => $request->is_active,
                    'pin_active'     => $request->pin_active,
                ]);
                return response()->json([
                    'status'    =>   true,
                    'message'   =>   'Đã cập nhật danh sách tủ thành công!'
                ]);
            } else {
                return response()->json([
                    'status'    =>   false,
                    'message'   =>   'Không tìm được tủ đồ để cập nhật!'
                ]);
            }
        }
       
    }
