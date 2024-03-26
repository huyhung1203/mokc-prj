@extends('layouts.welcome')
@section('checkin')
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="member-tab" data-toggle="tab" href="#member" role="tab" aria-controls="member"
                    aria-selected="true">Hội Viên</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="guest-tab" data-toggle="tab" href="#guest" role="tab" aria-controls="guest"
                    aria-selected="false">Khách</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="member" role="tabpanel" aria-labelledby="member-tab">
                <form id="memberForm" method="POST" action="{{ route('checkin.store') }}">
                    @csrf
                    <!-- Member form fields here -->
                    <h2 id="formHeading">Dành cho hội viên</h2>
                    <div class="form-group">
                        <label for="id">No*:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                                id="member_code" required>
                            <div class="input-group-append">
                                <a href="javascript:void(0)" id="searchMemberByCode" class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="id" class="form-control" name="id" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và Tên:</label>
                        <input type="text" id="name" class="form-control" name="full_name" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone_number" class="form-control" name="phone" value="" readonly>
                    </div>

                    <div class="form-group">
                        <label>Giới tính:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genderRadio" id="maleRadio" disabled>
                            <label class="form-check-label" for="maleRadio">
                                Nam
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genderRadio" id="femaleRadio" disabled>
                            <label class="form-check-label" for="femaleRadio">
                                Nữ
                            </label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mx-2 btn-checkin">Check In</button>
                        <button type="reset" class="btn btn-secondary mx-2">Clear</button>
                    </div>

                </form>
            </div>
            <div class="tab-pane fade" id="guest" role="tabpanel" aria-labelledby="guest-tab">
                <form id="guestForm" method="POST" action="{{ route('checkin.guest') }}" >
                    @csrf
                    <!-- Guest form fields here -->
                    <h2 id="formHeading">Dành cho Khách</h2>
                    <input type="hidden" name="is_gues" value="1">
                    <div class="form-group">
                        <label for="name">Họ và Tên:</label>
                        <input type="text" id="name" class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name') }}" name="full_name" required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone_number"
                            class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                            value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="dobInput">
                        <label for="dob">Ngày sinh:</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" 
                            value="{{ old('dob') }}" required>
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="@error('gender') is-invalid @enderror">Giới tính:</label>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="1" name="gender"
                                id="maleRadio" required>
                            <label class="form-check-label" for="maleRadio">
                                Nam
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="0" name="gender"
                                id="femaleRadio" required>
                            <label class="form-check-label" for="femaleRadio">
                                Nữ
                            </label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mx-2">Check
                            In</button>
                        <button type="reset" class="btn btn-secondary mx-2">Xóa</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- /.container-fluid -->
    <div class="container mt-5">
        <!--Thông báo để ở đây-->

    </div>
    <script src="{{ asset('access/js/thainn/checkin.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchMemberByCode").click(function() {
                var code = $('#member_code').val();
                $.ajax({
                    url: '{{ route('checkin.getMemberByCode') }}',
                    method: "get",
                    data: {
                        code: code,
                    },
                    success: function(response) {
                        if (response.success) {
                            var member = response.member;
                            var male = 1;
                            var famale = 0;
                            console.log("🚀 ~ $ ~ member:", member)
                            $('#id').val(member.id);
                            $('#name').val(member.full_name);
                            $('#phone_number').val(member.phone_number);
                            if (member.gender === male) {
                                $('#maleRadio').prop('checked', true);
                            } else if (member.gender === famale) {
                                $('#femaleRadio').prop('checked', true);
                            }
                            $('.btn-checkin').prop('disabled',false);
                        } else {
                            $('.btn-checkin').prop('disabled',true);
                            toastr.error('Không tìm thấy người dùng', '', {
                                "timeOut": 3000
                            });
                        }
                    }
                })
            })
        })

        @if (session('success'))
            $(document).ready(function() {
                toastr.success('{{ session('success') }}', '', {
                    "timeOut": 3000
                });
            });
        @endif
        @if (session('warning'))
            $(document).ready(function() {
                toastr.warning('{{ session('warning') }}', '', {
                    "timeOut": 3000
                });
            });
        @endif
        @if (session('error'))
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', '', {
                    "timeOut": 3000
                });
            });
        @endif
        // validate
    </script>
@endsection
