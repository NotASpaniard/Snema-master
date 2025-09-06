<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý snacks - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu và ghế</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
            <li><a href="{{ route('genres.index') }}"><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href="{{ route('snacks.index') }}" class="active"><i class="fas fa-cookie"></i> Quản lý snack</a></li>
            <li><a href="{{ route('admin.bookings') }}"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Trang quản trị</h1>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-primary">
                    <i class="fas fa-sign-out"></i> Đăng xuất
                </button>
            </form>
        </div>

            <div class="col-md-3 mb-4">
                <form action="{{ route('snacks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <th>Tiêu chí</th>
                            <th>Giá trị nhập</th>
                        </tr>

                        <tr>
                            <td>Tên đồ ăn/nước uống</td>
                            <td><input type="text" name="name" class="form-control" required></td>
                        </tr>

                        <tr>
                            <td>Hình ảnh</td>
                            <td><input type="file" name="image" class="form-control"></td>
                        </tr>

                        <tr>
                            <td>Mô tả</td>
                            <td><input type="text" name="description" class="form-control"></td>
                        </tr>

                        <tr>
                            <td>Trạng thái</td>
                            <td>
                                <select name="status">
                                    <option value="1">Còn hàng</option>
                                    <option value="0">Hết hàng</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Đơn giá</td>
                            <td><input type="number" name="price" class="form-control"></td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-primary">Thêm snack</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </main>
    </main>
</div>

<!--	Footer	-->
<div id="footer-bottom" class="bg-dark">
    <div class="container text-center text-light">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p>
                    2025 © <a href="https://bkacad.edu.vn">BKACAD</a>. All rights reserved. Developed by <a
                        href="https://github.com/Kurosagi19">Kurosagi19</a> and <a
                        href="https://www.facebook.com/DPawsParrot">DPawsParrot.</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!--	End Footer	-->

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
