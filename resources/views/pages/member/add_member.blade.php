@extends('layouts.welcome')
@section('add_member')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-info">Thêm Mới Hội Viên</h1>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('member.store') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Quay Lại
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <form action="{{ route('member.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Họ tên:</label>
                    <input 
                        type="text" 
                        name="full_name" 
                        value="{{ old('full_name') }}"
                        class="form-control @error('full_name') is-invalid @enderror" 
                        id="name" 
                        placeholder="John Doe"
                    >
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="dob">Ngày sinh:</label>
                    <input 
                        type="date" 
                        name="dob" 
                        value="{{ old('dob') }}"
                        class="form-control @error('dob') is-invalid @enderror" 
                        id="dob"
                    >
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="gender">Giới Tính:</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="gender">
                        <option value="">--chọn--</option>
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="address">Địa chỉ:</label>
                    <input 
                        name="address" value="{{ old('address') }}" 
                        type="text"
                        class="form-control @error('address') is-invalid @enderror" 
                        id="address"
                        placeholder="123 Main Street"
                    >
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input 
                        name="phone_number" 
                        value="{{ old('phone_number') }}"
                        class="form-control @error('phone_number') is-invalid @enderror" 
                        id="phone"
                        placeholder="123-456-7890"
                        >
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="email">Email:</label>
                    <input 
                        name="email" 
                        value="{{ old('email') }}" 
                        type="email"
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email"
                        placeholder="john@example.com"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center"> <!-- Center the buttons -->
                    <button type="reset" class="btn btn-secondary mx-2">Xóa</button>
                    <button type="submit" class="btn btn-primary mx-2">Thêm</button>
                </div>
        </form>
    </div>
@endsection
