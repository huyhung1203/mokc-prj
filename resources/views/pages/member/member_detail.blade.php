@extends('layouts.welcome')
@section('member_details')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-info">Thông Tin Hội Viên</h1>
        <div class="mt-3 mt-sm-0">
            <a href="{{ URL::to('/member') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form method="POST" action="{{ route('member.update', $member->id) }}">
            @csrf
            @method('PUT')
            <!-- Your form fields -->
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="name">Họ Tên:</label>
                        <input 
                            type="text" 
                            name="full_name" 
                            value="{{ $member->full_name }}" 
                            class="form-control @error('full_name') is-invalid @enderror"
                            id="name" 
                            placeholder="John Doe"
                        >
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="image">QR Code:</label>
                        <span style="margin-left: 20px;">{{ $qrCode }}</span>
                    </div>
                </div> 
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select name="gender" class="form-control" id="gender">
                            <option value="">--chọn--</option>
                            <option value="1" {{ $member->gender == config('custom.male') ? 'selected' : '' }}>Nam</option>
                            <option value="2" {{ $member->gender == config('custom.female') ? 'selected' : '' }}>Nữ</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input 
                            name="address" 
                            value="{{ $member->address }}" 
                            type="text" 
                            class="form-control @error('address') is-invalid @enderror"
                            id="address" 
                            placeholder="123 Main Street"
                        >
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input 
                            type="tel" 
                            name="phone_number" 
                            value="{{ $member->phone_number }}" 
                            class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone" 
                            placeholder="099-999-9999"
                        >
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ $member->email }}" 
                            class="form-control @error('email') is-invalid @enderror"
                            id="email" 
                            placeholder="john@example.com"
                            >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
           <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="dob">Ngày sinh:</label>
                            <input 
                                name="dob" 
                                value="{{ $member->dob }}"
                                type="date" 
                                class="form-control @error('dob') is-invalid @enderror"
                                id="dob"
                            >
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="renewal">Gia hạn:</label>
                        <select name="renewal" class="form-control" id="renewal">
                            <option value="">--chọn--</option>
                            <option value="1">1 tháng</option>
                            <option value="3">3 tháng</option>
                            <option value="6">6 tháng</option>
                            <option value="12">12 tháng</option>
                        </select>
                    </div>
                </div>
           </div>
           <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <label for="ended_date">Ngày hết hạn:</label>
                    <input 
                        name="ended_date" 
                        value="{{ $member->ended_date }}"
                        type="date" 
                        class="form-control @error('ended_date') is-invalid @enderror"
                        id="ended_date"
                        readonly
                    >
                    @error('ended_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @php
                // Check if ended_date is less than current date
                $today = now()->toDateString();
                $expired = ($member->ended_date < $today) ? true : false;
            @endphp
            @if($expired)
                <div class="col">
                    <div class="alert alert-danger mt-4" role="alert">
                        Tài khoản đã hết hạn. Vui lòng gia hạn.
                    </div>
                </div>
            @endif
        </div>
            <div class="text-center"> <!-- Center the buttons -->
                <button type="submit" class="btn btn-secondary mx-2">Xóa</button>
                <button type="submit" class="btn btn-primary mx-2">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
