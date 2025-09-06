<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Thống kê</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
        }
        .card-title {
            font-weight: 600;
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
            <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.locations') }}"><i class="fas fa-solid fa-map-location-dot"></i> Quản lý vị trí</a></li>
            <li><a href="{{ route('admin.cinemas') }}"><i class="fas fa-solid fa-clapperboard"></i> Quản lý rạp</a></li>
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu và ghế</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
            <li><a href=""><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href="{{ route('snacks.index') }}"><i class="fas fa-cookie"></i> Quản lý snack</a></li>
            <li><a href="{{ route('admin.bookings') }}"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
            <div class="admin-user">
                <span>Xin chào, Quản trị viên {{ $admin }}</span>
            </div>
            <div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-out"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>

        <div class="container py-5">
            <h2 class="mb-4 text-center">Thống kê hệ thống đặt vé phim</h2>

            <!-- Thống kê tổng quan -->
            <div class="row mb-4">
                <div class="col-md-4 sm-6">
                    <div class="card shadow-sm p-4 text-center">
                        <h5 class="card-title">Tổng số phim</h5>
                        <p class="display-6 fw-bold text-primary">{{ $total_movies }}</p>
                    </div>
                </div>

                <div class="col-md-4 sm-6">
                    <div class="card shadow-sm p-4 text-center">
                        <h5 class="card-title">Tổng số khách hàng</h5>
                        <p class="display-6 fw-bold text-success">{{ $total_customers }}</p>
                    </div>
                </div>

                <div class="col-md-4 sm-6">
                    <div class="card shadow-sm p-4 text-center">
                        <h5 class="card-title">Tổng số vé đã đặt</h5>
                        <p class="display-6 fw-bold text-success">{{ $total_bookings }}</p>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ doanh thu -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Doanh thu theo tháng</h5>
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<!--	Footer	-->
<div id="footer-bottom" class="bg-dark">
    <div class="container text-center text-light">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p>
                    2025 © <a href="https://bkacad.edu.vn">BKACAD</a>. All rights reserved. Developed by <a href="https://github.com/Kurosagi19">Kurosagi19</a> and <a href="https://www.facebook.com/DPawsParrot">DPawsParrot</a>.
                </p>
            </div>
        </div>
    </div>
</div>
<!--	End Footer	-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode($chart_data) !!},
                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
