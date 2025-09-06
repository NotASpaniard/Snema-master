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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
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
                <h1 class="page-title">Quản lý phòng chiếu</h1>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </div>

            <a href="{{ route('rooms.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Thêm phòng chiếu</a>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Mã phòng</th>
                        <th>Số phòng</th>
                        <th>Số lượng ghế</th>
                        <th>Rạp</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>
                                {{ $room->room_number }}
                            </td>
                            <td>
                                {{ $room->total_seat }}
                            </td>
                            <td>
                                {{ $room->cinema->name }}
                            </td>
                            <td>
                                {{ $room->cinema->location->location_name }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('rooms.seats', $room->id) }}" class="btn btn-outline-info btn-sm">
                                        Xem sơ đồ ghế
                                    </a>
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning me-2">Sửa</a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Xác nhận xoá phòng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xoá</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Không có phòng chiếu nào</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
