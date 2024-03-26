<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemBerRequest extends FormRequest
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
            //
            'full_name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:members,email', // kiểm tra trên database 
            'phone_number' => 'required|regex:/^(0[1-9])+([0-9]{8})\b$/',
            'address' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:0,1',
        ];
    }
    public function messages() {
        return [
            //
            'email.unique' => 'Email đã đăng ký!',
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Vui lòng nhập đúng định dạng!',
            'full_name.required' => 'Vui lòng nhập họ tên!',
            'full_name.regex' => 'Họ tên không chứa kí tự và số!',
            'phone_number.required' => 'Vui lòng nhập sđt!',
            'phone_number.regex' => 'Vui lòng nhập đúng định dạng số điện thoại!',
            'address.required' => 'Vui lòng nhập địa chỉ!',
            'dob.required' => 'Vui lòng nhập ngày sinh!',
            'dob.date' => 'Vui lòng nhập đúng định dạng ngày sinh!',
            'gender.required' => 'Vui lòng chọn giới tính!',
        ];
    }
}
