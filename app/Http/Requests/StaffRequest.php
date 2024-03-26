<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'full_name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|max:20|unique:users,phone_number',
            'dob' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ tên',
            'full_name.regex' => 'Họ tên không được chứa kí tự và số',
            'full_name.max' => 'Họ tên chỉ tối đa 50 kí tự',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'email.unique' => 'Email đã đăng ký .',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.unique' => 'Số điện thoại đã đăng ký.',
            'dob.required' => 'Vui chọn ngày sinh.',
            'dob.date' => 'Vui chọn định dạng ngày sinh.',
        ];
    }
}
