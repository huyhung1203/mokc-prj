@extends('layouts.welcome')
@section('add_staff')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-info">Thông Tin Của Staff</h1></h1>
    <div class="mt-3 mt-sm-0">
        <a href="{{ route('staff.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Quay Lại
        </a>
    </div>
</div>

<div class="container mt-5">
    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="name">Họ Tên:</label>
            <input type="text" class="form-control" id="name" placeholder="John Doe" name="full_name" value="{{ $staff->full_name }}" required>
        </div>

        <div class="form-group">
            <label for="dob">Ngày Sinh:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="{{ $staff->dob }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Số Điện Thoại:</label>
            <input type="tel" class="form-control" id="phone" placeholder="123-456-7890" name="phone_number" value="{{ $staff->phone_number }}" required size="10" maxlength="10" minlength="9">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="john@example.com" name="email" value="{{ $staff->email }}" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
        </div>


        <div class="text-center"> <!-- Center the buttons -->
            <button type="reset" class="btn btn-secondary mx-2">Làm Mới</button>
            <button type="submit" class="btn btn-primary mx-2">Lưu</button>
        </div>
    </form>
</div>
@endsection
