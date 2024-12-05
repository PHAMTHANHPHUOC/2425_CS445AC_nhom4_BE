<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoiMatKhaurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password'          =>  'required|min:6|max:50',
            're_password'       =>  'required|same:password',
        ];
    }
    public function messages()
    {
        return [
            'password.*'          =>  'Mật khẩu phải từ 6 đến 50 ký tự',
            're_password.*'       =>  'Mật khẩu nhập lại không giống nhau',
        ];
    }
}
