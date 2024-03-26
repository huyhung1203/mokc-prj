@extends('layouts.welcome')
@section('list')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-info">Danh Sách Check In</h1>
    {{-- <div class="mt-3 mt-sm-0">
        <button class="btn btn-sm btn-outline-primary mr-2 btn-export"data-action="{{route('inout.export')}}">
            <i class="fas fa-download fa-sm text-primary-50 mr-1" ></i> Xuất File
        </button>
    </div> --}}
</div>

<div class="container mt-5">
    <form id="search-inout" action="{{ route('inout.index') }}" method="GET">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="startDate">Ngày:</label>
                <input type="date" value="{{ session('data.checkDate') }}" class="form-control" name="checkDate">
            </div>
            <div class="form-group col-md-6">
                <label for="startDate">Vai trò:</label>
                <select name="guest" id="is_gues" class="form-control">
                    <option value="">--chọn--</option>
                    <option value="1" @if(session('data.guest') == 1) selected @endif >Khách</option>
                    <option value="0" @if(session('data.guest') == 0) selected @endif>Hội viên</option>
                </select>
            </div>
        </div>
            
        <div class="text-center">
            <a href="{{ route('inout.index') }}" class="btn btn-secondary mx-2">Làm Mới</a>
            <button type="submit" class="btn btn-primary mx-2">Tìm Kiếm</button>
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
        <th scope="col">Họ Tên</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Ngày check-in</th>
        <th scope="col">SĐT</th>
        <th scope="col">Vai trò</th>
       
        <!-- Add more columns as needed -->
    </tr>
</thead>
    <tbody>
        <!-- Table rows will be dynamically populated by DataTables -->
       @forelse ($list as $item)
           <tr>
               <td>{{$item->id}}</td>
               <td>{{$item->members->full_name}}</td>
               <td>{{$item->members->address}}</td>
               <td>{{$item->check_in_date}}</td>
               <td>{{$item->members->phone_number}}</td>
               <td>{{$item->members->is_gues == config('custom.is_guest') ? 'Hội viên':'Khách'}}</td>
           </tr>
       @empty
           
       @endforelse
        
    </tbody>
</table>
{{ $list->onEachSide(2)->links('pagination.default') }}
</div>
@endsection