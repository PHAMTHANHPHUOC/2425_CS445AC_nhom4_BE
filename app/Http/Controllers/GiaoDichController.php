<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\GiaoDich;
use App\Models\KhachHang;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiaoDichController extends Controller
{
    public function index()
    {


        $client = new Client();
        $payload = [
            "USERNAME"      => "0347941497",
            "PASSWORD"      => "PhamPhuoc1512.",
            "DAY_BEGIN"     => Carbon::today()->format('d/m/Y'),
            "DAY_END"       => Carbon::today()->format('d/m/Y'),
            "NUMBER_MB"     => "0347941497"
        ];

        try {
            $response = $client->post('http://103.137.185.71:2603/mb', [
                'json' => $payload
            ]);

            $data   = json_decode($response->getBody(), true);
            $duLieu = $data['data'];

            foreach ($duLieu as $key => $value) {
                $giaoDich   = GiaoDich::where('pos', $value['pos'])
                    ->where('creditAmount', $value['creditAmount'])
                    ->where('description', $value['description'])
                    ->first();

                if (!$giaoDich) {
                    GiaoDich::create([
                        'creditAmount'      =>  $value['creditAmount'],
                        'description'       =>  $value['description'],
                        'pos'               =>  $value['pos'],

                    ]);
                    // Khi mà chúng ta tạo giao dịch => tìm giao dịch dựa vào description => đổi trạng thái của đơn hàng
                    // Khi mà chúng ta tạo giao dịch => tìm giao dịch dựa vào description => đổi trạng thái của đơn hàng
                    $description = $value['description'];
                    // Tìm vị trí của chuỗi "HDBH"
                    $pattern = '/PTP\d+/';

                    preg_match($pattern, $description, $matches);

                    // $matches[0] sẽ chứa chuỗi được tìm thấy
                    if (!empty($matches)) {
                        $maDonHang = $matches[0]; // PTP151236
                        $donHang = DonHang::where('ma_don_hang', $maDonHang)
                                          ->first();
                        if ($donHang) {
                            $donHang->is_thanh_toan = 1;
                            $donHang->save();

                            $user = KhachHang::find($donHang->id_khach_hang);
                            $user->tong_tien = $user->tong_tien + $value['creditAmount'];
                            $user->save();
                        }
                    }


                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
   
}
