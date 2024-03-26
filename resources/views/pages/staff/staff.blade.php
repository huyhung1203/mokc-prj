@extends('layouts.welcome')
@section('staff')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-info">Quản lý Staff</h1>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('staff.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle fa-sm text-white-50 mr-1"></i> Thêm Staff
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form method="GET" action="{{ route('staff.index') }}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id">No:</label>
                    <input type="text" class="form-control" name="id" value="{{ session('search.id') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Họ và Tên:</label>
                    <input type="text" class="form-control" name="name" value="{{ session('search.name') }}">
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('staff.index') }}" type="reset" class="btn btn-secondary mx-2">Clear</a>
                <button type="submit" class="btn btn-primary mx-2">Tìm Kiếm</button>
            </div>
        </form>
    </div>


    <!-- /.container-fluid -->

    <div class="container mt-5">

        <div class="table-responsive">
            <!-- Bootstrap Table -->
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Số Điện Thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Thao tác</th>

                    </tr>
                </thead>
                <tbody>
                    @if (isset($staffList) && is_object($staffList))
                        @foreach ($staffList as $staff)
                            <tr>
                                <td>{{ $staff->id }}</td>
                                <td>{{ $staff->full_name }}</td>
                                <td>{{ $staff->phone_number }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->level == config('custom.level') ? 'Admin' : 'Staff' }}</td>
                                
                                    <td>
                                        <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i> <!-- Edit icon -->
                                        </a>
                                        @if(auth()->user()->id == 1)
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal{{ $staff->id }}">
                                                <i class="fas fa-trash-alt"></i> <!-- Delete icon -->
                                            </button>
                                        @endif
                                    </td>
                               
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $staffList->onEachSide(2)->links('pagination.default') }}
        </div>
        @foreach ($staffList as $staff)
            <div class="modal fade" id="deleteModal{{ $staff->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $staff->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $staff->id }}">Xác Nhận Muốn Xóa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn xóa "{{ $staff->full_name }}"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


@endsection
@push('staff')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
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
@endpush
