@extends('layouts.welcome')
@section('dashboard')
     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống Kê Đối Tượng</h1>
        
    </div>

    <div class="container mt-5">
        <form id="searchForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="startDate">Ngày tháng *</label>
                    <div class="input-group">
                        <input type="date" class="form-control mb-2 mr-sm-2" id="startDate" name="startDate" >
                        <input type="date" class="form-control mb-2 mr-sm-2" id="endDate" name="endDate" >
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Type*</label>
                    <div class="input-group">
                        <select class="form-control mb-2 mr-sm-2" id="type" name="type">
                            <option value="day">Day</option>
                            <option value="month">Month</option>
                        </select>
                    </div>
                </div>
            </div>
        
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="targetSelect">Loại: </label>
                    <select class="form-control" id="targetSelect" name="targetSelect">
                        <option value="none">---</option>
                        <option value="member">Hội viên</option>
                        <option value="non-member">Không phải hội viên</option>
                    </select>
                </div>
            
                <div class="form-group col-md-6">
                    <label for="ageSelect">Tuổi: </label>
                    <select class="form-control" id="ageSelect" name="ageSelect">
                        <option value="none">---</option>
                        <option value="under18">Dưới 18 tuổi</option>
                        <option value="above18">Trên 18 tuổi</option>
                    </select>
                </div>
            </div>
            
        
            <div class="text-center">
                <!-- Center the buttons -->
                <a href="{{ route('home') }}" class="btn btn-secondary mx-2">Làm mới</a>
                <button type="button" class="btn btn-primary mx-2" onclick="search()">Thống Kê</button>
            </div>
        </form>
        
    </div>

    <div class="mt-5">
        <canvas id="myChart" width="800" height="250"></canvas>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        window.onload = function() {
            fetch('{{ route('searchIndex') }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Vui lòng nhập dữ liệu để tìm kiếm');
                }
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    throw new Error('Không có dữ liệu');
                }
                var labels = [];
                var guestsData = [];
                var membersData = [];
                data.forEach(item => {
                    labels.push(item.date);
                    guestsData.push(item.guests_count);
                    membersData.push(item.members_count);
                });
                updateChart(labels, guestsData, membersData);
            })
            .catch(error => {
                alert(error.message);
            });
        }

        function search() {
            var form = document.getElementById("searchForm");
            var formData = new FormData(form);
    
            fetch('{{ route('search') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Vui lòng nhập dữ liệu để tìm kiếm');
                }
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    throw new Error('Không có dữ liệu');
                }
                var labels = [];
                var guestsData = [];
                var membersData = [];
                data.forEach(item => {
                    labels.push(item.date);
                    guestsData.push(item.guests_count);
                    membersData.push(item.members_count);
                });
                updateChart(labels, guestsData, membersData);
            })
            .catch(error => {
                alert(error.message);
            });
        }
    
        function updateChart(labels, guestsData, membersData) {
            var ctx = document.getElementById('myChart');
            if (window.myChart instanceof Chart) {
                window.myChart.destroy();
            }
            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Khách',
                        data: guestsData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Hội Viên',
                        data: membersData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        @if (session('success'))
            $(document).ready(function() {
                toastr.success('{{ session('success') }}', '', {"timeOut": 3000}); 
            });
        @endif
        @if (session('error'))
            $(document).ready(function() {
                toastr.error('{{ session('error') }}', '', {"timeOut": 3000}); 
            });
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
@endsection