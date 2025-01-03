<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatTuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                'ten_san_pham'   => 'required|min:4|max:100',
                'hinh_anh'       => 'required|min:4|max:10000',
                'gia_ban'        => 'required|min:4|max:100',
                'is_active'      => 'required|min:1',
                'has_active'     => 'required|min:1',
                'pin_active'     => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'ten_san_pham.*'   => 'Vui lòng nhập tên sản phẩm',
            'hinh_anh.*'       => 'vui lòng nhập hình ảnh',
            'gia_ban.*'        => 'vui lòng nhập giá bán',
            'is_active.*'      => 'vui lòng nhập tình trạng',
            'has_active.*'     => 'vui lòng nhập trạng thái',
            'pin_active.*'     => 'vui lòng nhập mã pin từ 6 số trở lên',
        ];
    }
}
