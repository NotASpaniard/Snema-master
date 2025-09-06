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
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
            <li><a href="{{ route('genres.index') }}"><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href="{{ route('snacks.index') }}"><i class="fas fa-cookie"></i> Quản lý snack</a></li>
            <li><a href="{{ route('admin.bookings') }}" class="active"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">Quản lý đơn hàng</h1>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Mã HD</th>
                        <th>Khách hàng</th>
                        <th>Phim</th>
                        <th>Suất chiếu</th>
                        <th>Ghế</th>
                        <th>Đồ ăn</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                {{ $booking->customers->name }}<br>
                                <small>{{ $booking->customers->phone_number }}</small>
                            </td>
                            <td>
                                {{ $booking->showtime->movie->title }}<br>
                                <small>Phòng: {{ $booking->showtime->room->room_number }}</small>
                            </td>
                            <td>
                                {{ date('H:i', strtotime($booking->showtime->start_time)) }} -
                                {{ date('H:i', strtotime($booking->showtime->end_time)) }}<br>
                                <small>{{ $booking->showtime->room->cinema->name }}</small>
                            </td>
                            <td>
                                @foreach($booking->booking_details as $detail)
                                    {{ $detail->seat->seat_code }} ({{ $detail->seat->seat_type }})<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($booking->booking_snacks->getAllSnacks() as $snackItem)
                                    <div>
                                        • {{ $snackItem['name'] }}
                                        (SL: {{ $snackItem['quantity'] }}
                                        - Tổng: {{ number_format($snackItem['total_price']) }}đ)
                                    </div>
                                @endforeach
                            </td>
                            <td>{{ number_format($booking->final_price) }}đ</td>
                            <td>
                                @if($booking->status == 1)
                                    <span class="status-completed"><i class="fas fa-check-circle"></i> Hoàn thành</span>
                                @elseif($booking->status == 0)
                                    <span class="status-cancelled"><i class="fas fa-times-circle"></i> Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->booking_details->isNotEmpty())
                                    {{ $booking->booking_details->first()->booking_time }}
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn huỷ vé này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Huỷ vé</button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Không có vé nào</td>
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
