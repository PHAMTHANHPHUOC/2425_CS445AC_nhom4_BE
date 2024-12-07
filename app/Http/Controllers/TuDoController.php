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
        public function updatePin(Request $request)
        {
            $data = TuDo::where('id', $request->id)->first();
            if($data){
                $data->update([
                    'pin_active' => $request->pin_active
                ]);
                return response()->json([
                    'message'  =>   'Đã cập nhật mã pin thành công!',
                    'status'   =>   true
                ]);
            }
            return response()->json([
                'message'  =>   'đã cập nhật mã pin thất bại',
                'status'   =>   false
            ]);

        }


    }
