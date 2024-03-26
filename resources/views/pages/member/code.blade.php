<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code</title>
    <style>
        /* Add your custom styles here */
        .invoice {
            font-family: Arial, sans-serif;
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        
        .invoice-header {
            text-align: center;
            padding: 20px;
        }
        
        .invoice-body {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            {!! $qrCode !!}
        </div>
        <div class="invoice-body">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%;">Mã Hội Viên</th>
                        <th style="width: 30%;">Tên Hội Viên</th>
                        <th style="width: 30%;">Email</th>
                        <th style="width: 20%;">Số Điện Thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $member->code }}</td>
                        <td>{{ $member->full_name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
