<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đổi Mật Khẩu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 100px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Đổi Mật Khẩu</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" role="form" method="POST" action="{{ route('change.password') }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="inputPasswordOld">Mật Khẩu Hiện Tại</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="inputPasswordOld" name="old_password" >
                            </div>
                            @if (session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                            @endif
                            @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="newPasswordInput">Mật Khẩu Mới</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput" name="new_password"  >
                                <small class="form-text text-muted">
                                    Mật khẩu có độ dài từ 8-20 kí tự, và <em>không</em> được chứa dấu cách.
                                </small>
                            </div>
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="inputPasswordNewVerify">Xác Nhận Lại Mật Khẩu</label>
                                <input type="password" class="form-control" id="inputPasswordNewVerify" name="new_password_confirmation" >
                                <small class="form-text text-muted">
                                    Xác Nhận Lại Mật Khẩu Mới.
                                </small>
                            </div>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg float-right">Lưu</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</html>