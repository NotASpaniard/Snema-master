<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý rạp - Admin Panel</title>
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
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-primary">
                    <i class="fas fa-sign-out"></i> Đăng xuất
                </button>
            </form>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.locations') }}"><i class="fas fa-solid fa-map-location-dot"></i> Quản lý vị trí</a></li>
            <li><a href="#" class="active"><i class="fas fa-solid fa-clapperboard"></i> Quản lý rạp</a></li>
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
            <li><a href="{{ route('genres.index') }}"><i class="fas fa-tags"></i> Quản lý thể loại</a></li>
            <li><a href="{{ route('snacks.index') }}"><i class="fas fa-cookie"></i> Quản lý snack</a></li>
            <li><a href="{{ route('admin.bookings') }}"><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li><a href="{{ route('admin.customers') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i> Quản lý admin</a></li>
        </ul>
    </aside>


    <main class="main-content">
        <div class="col-md-3 mb-4">
            <form action="{{ route('cinemas.update', $cinema->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label for="name">Tên rạp:</label>
                <input type="text" name="name" value="{{ $cinema->name }}" class="form-control" required>

                <label for="email">Email:</label>
                <input type="email" name="email" value="{{ $cinema->email }}" class="form-control">

                <label for="phone_number">Số điện thoại:</label>
                <input type="text" name="phone_number" value="{{ $cinema->phone_number }}" class="form-control">

                <label for="description">Mô tả:</label>
                <textarea name="description" class="form-control">{{ $cinema->description }}</textarea>

                <label for="location_id">Vị trí:</label>
                <select name="location_id" class="form-select">
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected($cinema->location_id == $location->id)>
                            {{ $location->location_name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
            </form>

        </div>
    </main>
</div>

</body>
</html>
