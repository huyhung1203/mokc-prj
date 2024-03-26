<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8|max:20',
        ];
    }

    public function messages(){
        return [
            'old_password.required' => 'Mật khẩu cũ không được để trống',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.confirmed' => 'Mật khẩu không trùng khớp',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'new_password.max' => 'Mật khẩu mới phải có nhiều nhất 20 ký tự',
        ];
    }
}
