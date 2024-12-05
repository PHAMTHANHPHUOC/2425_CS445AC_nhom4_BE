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
        public function thanhToan(Request $request)
        {
            $khach_hang = Auth::guard('sanctum')->user();
            $data = TuDo::where('id', $request->id)->first();
            if ($data) {
                if ($data->gia_ban <= $khach_hang->tong_tien) {
                    $user = KhachHang::find($khach_hang->id);
                    $so_tien_con_lai = $user->tong_tien - $data->gia_ban;
                    $user->update([
                        'tong_tien' => $so_tien_con_lai,
                    ]);

                    // Tính thời gian hết hạn
                    $expirationTime = Carbon::now()->addHour(); // Thời gian hết hạn là 1 tiếng từ lúc thanh toán
                    $data->is_active        = 1;
                    $data->id_khach_hang    = $user->id;
                    $data->expiration_time  = $expirationTime; // Lưu thời gian hết hạn (cần thêm trường này vào bảng)

                    $data->save();

                    return response()->json([
                        'message'  => 'Đã Thanh Toán thành công! mã pin tủ đồ của bạn là : ' . $data->pin_active . '. Thời gian hết hạn: ' . $expirationTime->format('H:i:s'),
                        'status'   => true
                    ]);
                } else {
                    return response()->json([
                        'message'  => 'Số Tiền Của Bạn Không Đủ Để Thanh Toán',
                        'status'   => false
                    ]);
                }
            }   
        }

    }
