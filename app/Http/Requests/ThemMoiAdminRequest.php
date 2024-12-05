<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemMoiAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ho_va_ten'         =>  'required|min:4|max:100',
            'email'             =>  'required|email|unique:khach_hangs,email',
            'so_dien_thoai'     =>  'required|digits:10',
            'password'          =>  'required|min:6|max:50',
            're_password'       =>  'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.*'         =>  'Họ và tên phải từ 4 đến 100 ký tự',
            'email.*'             =>  'Email đã tồn tại hoặc không đúng định dạng',
            'so_dien_thoai.*'     =>  'Số điện thoại phải 10 số',
            'password.*'          =>  'Mật khẩu phải từ 6 đến 50 ký tự',
            're_password.*'       =>  'Mật khẩu nhập lại không giống nhau',
        ];
    }
}
