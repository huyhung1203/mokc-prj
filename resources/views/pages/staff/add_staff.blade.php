@extends('layouts.welcome')
@section('add_staff')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-info">Thêm Mới Staff</h1>
    <div class="mt-3 mt-sm-0">
        <a href="{{route('staff.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Quay Lại
        </a>
    </div>
</div>
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
<div class="container mt-5">
    <form method="POST" action="{{ route('staff.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Họ Tên:</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="name"  value="{{ old('full_name') }}" placeholder="John Doe" name="full_name"  >
            @error('full_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="dob">Ngày sinh :</label>
            <input type="date" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" id="dob" name="dob" >
            @error('dob')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" id="phone" placeholder="123-456-7890" name="phone_number"  size="10" maxlength="10" minlength="9">
            @error('phone_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email"  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" placeholder="john@example.com" name="email"  pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="level">Level</label>
            <select class="form-control" name="level" id="level" >
                <option value="">--chọn--</option>
                <option value="0">Admin</option>
                <option value="1">Staff</option>
            </select>
        </div>


        <div class="text-center"> <!-- Center the buttons -->
            <button type="" class="btn btn-secondary mx-2">Clear</button>
            <button type="submit" class="btn btn-primary mx-2">Thêm</button>
        </div>
    </form>
</div>
@endsection
