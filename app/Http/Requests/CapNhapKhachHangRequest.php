<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapKhachHangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'                =>  'required|exists:khach_hangs,id',
            'ho_va_ten'         =>  'required|min:4|max:100',
            'email'             =>  'required|email|unique:khach_hangs,email,'. $this->id,
            'so_dien_thoai'     =>  'required|digits:10',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                =>  'Khách hàng phải tồn tại trong hệ thống!',
            'ho_va_ten.*'         =>  'Họ và tên phải từ 4 đến 100 ký tự',
            'email.required'          => 'Email không được để trống',
            'email.email'             => 'Email không đúng định dạng',
            'email.unique'            => 'Email đã tồn tại',
            'so_dien_thoai.*'     =>  'Số điện thoại phải 10 số',
        ];
    }
}
