@extends('layouts.welcome')
@section('member')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-info">Quản lý Hội Viên</h1>
        <div class="mt-3 mt-sm-0">
            <button class="btn btn-sm btn-outline-primary mr-2 btn-export" data-action="{{ route('member.export') }}">
                <i class="fas fa-download fa-sm text-primary-50 mr-1"></i> Xuất File
            </button>
            <a href="{{ route('member.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Thêm Hội Viên
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form id="search" method="get" action="{{ route('member.index') }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id">No:</label>
                    <input type="text" class="form-control" name="code" value="{{ session('search.code') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Họ và Tên:</label>
                    <input type="text" class="form-control" name="name" value="{{ session('search.name') }}">
                </div>
            </div>
            <div class="text-center"> <!-- Center the buttons -->
                <button type="reset" class="btn btn-secondary btn-clear mx-2">Xóa</button>
                <button id="btn-search" type="submit" class="btn btn-primary mx-2">Tìm Kiếm</button>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
    <div class="container mt-5">
        <!-- Bootstrap Table -->
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Code</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Hết hạn</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Email</th>
                    <th scope="col">Thao tác</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be dynamically populated by DataTables -->
                @forelse ($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td><a href="{{ route('member.show', $member->id) }}">{{ $member->code }}</a></td>
                        <td>{{ $member->full_name }}</td>
                        <td>{{ $member->ended_date }}</td>
                        <td>{{ $member->address }}</td>
                        <td>{{ $member->phone_number }}</td>
                        <td>{{ $member->email }}</td>
                        <td style="width: 150px">
                            <!-- Print button with icon -->
                            <button type="button" class="btn btn-info btn-sm btn-print" data-toggle="modal"
                                data-target="#editModal" data-id="{{ $member->id }}" data-code="{{ $member->code }}"
                                data-name="{{ $member->full_name }}">
                                <i class="fas fa-print"></i>
                            </button>

                            <!-- Edit button with icon -->
                            <a href="{{ route('member.show', $member->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete button with icon -->
                            <form action="{{ route('member.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Dữ liệu trống.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $members->links('pagination.default') }}
    </div>

    </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog">
        <form id="print-form-pdf" action="{{ route('print-member', ':id') }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">QRCODE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- QR Code -->
                                <div class="text-center mb-3">
                                    <div id="qrCode" class="qrCode"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">Name:</h6>
                                    <p id="name"></p>
                                </div>
                                <!-- Code -->
                                <div>
                                    <h6 class="font-weight-bold">Code:</h6>
                                    <p id="code"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="print-pdf" class="btn btn-primary">Print</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Thêm sự kiện click vào nút btn-print
        $('.btn-print').on('click', function() {
            var name = $(this).data('name');
            var code = $(this).data('code');
            var id = $(this).data('id');
            $('#print-form-pdf').attr('action', "{{ route('print-member', ':id') }}".replace(':id', id));
            // Gửi yêu cầu AJAX
            $.ajax({
                url: '{{ route('getQRCode') }}',
                method: 'GET',
                data: {
                    name: name,
                    code: code
                },
                success: function(response) {
                    // Hiển thị mã QR trong modal
                    $('#qrCode').html(response);
                    $('#name').html(name);
                    $('#code').html(code);
                    $('.modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Request failed. Error: ' + error);
                }
            });
        });
        $(document).ready(function() {
            // Xử lý sự kiện khi click nút "Clear"
            $('.btn-clear').on('click', function() {
                // Xóa giá trị của các input trong form
                $('input[name="code"]').val('');
                $('input[name="name"]').val('');

                // Thay đổi URL của trang đến trang danh sách thành viên ban đầu
                window.location.href = '{{ route('member.index') }}';
            });
        });
        $(document).ready(function() {
            $('.btn-export').on('click', function() {
                event.preventDefault();
                $actionUrl = $(this).data('action')
                $('#search').attr('action', $actionUrl).submit();
                $('#search').attr('action', '');
            })
        })
        @if (session('success'))
            $(document).ready(function() {
                toastr.success('{{ session('success') }}', '', {
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
    </script>
@endsection
