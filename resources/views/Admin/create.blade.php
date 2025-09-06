<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phim - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

</head>
<body>
<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <form method="POST" action="#">
                @csrf
                <button class="btn btn-primary">
                    <i class="fas fa-sign-out"></i> Đăng xuất
                </button>
            </form>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.movies') }}" class="active"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href=""><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
            <li><a href=""><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href=""><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href=""><i class="fas fa-cookie"></i> Quản lý snack</a></li>
        </ul>
    </aside>


    <main class="main-content">
        <div class="col-md-3 mb-4">
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered" style="width: 100%;">
                    <tr>
                        <th>Tiêu chí</th>
                        <th>Giá trị nhập</th>
                    </tr>

                    <tr>
                        <td>Tên</td>
                        <td><input type="text" name="name" class="form-control" required></td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" class="form-control" required></td>
                    </tr>

                    <tr>
                        <td>Mật khẩu</td>
                        <td><input type="text" name="password" class="form-control" required></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-primary">Thêm admin</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
</div>

</body>
</html>
