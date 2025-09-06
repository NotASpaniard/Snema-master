<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .table-container {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .status-pending {
            color: #ffc107;
        }
        .status-completed {
            color: #28a745;
        }
        .status-cancelled {
            color: #dc3545;
        }
    </style>
</head>
<body>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.locations') }}"><i class="fas fa-solid fa-map-location-dot"></i> Quản lý vị trí</a></li>
            <li><a href="{{ route('admin.cinemas') }}"><i class="fas fa-solid fa-clapperboard"></i> Quản lý rạp</a></li>
            <li><a href="{{ route('admin.rooms') }}" class="active"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu và ghế</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
            <li><a href="{{ route('genres.index') }}"><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href="{{ route('snacks.index') }}"><i class="fas fa-cookie"></i> Quản lý snack</a></li>
            <li><a href="{{ route('admin.bookings') }}"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">Thêm phòng chiếu</h1>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </div>

            <div class="col-mb-3 md-4">
                <form method="post" action="{{ route('rooms.store') }}">
                    @csrf

                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <th>Tiêu chí</th>
                            <th>Giá trị nhập</th>
                        </tr>

                        <tr>
                            <td>Số phòng</td>
                            <td><input type="text" name="room_number" required></td>
                        </tr>

                        <tr>
                            <td>Số lượng ghế</td>
                            <td><input type="number" name="total_seat" required></td>
                        </tr>

                        <tr>
                            <td>Rạp chiếu</td>
                            <td>
                                <select name="cinema_id" id="cinema_id">
                                        @foreach($cinemas as $cinema)
                                    <option value="{{ $cinema->id }}">{{ $cinema->name }} - {{ $cinema->location->location_name }}</option>
                                        @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>

                    <button type="submit" class="btn btn-success">Thêm phòng chiếu</button>

                </form>
            </div>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
