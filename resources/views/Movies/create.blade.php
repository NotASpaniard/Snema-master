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
            <li><a href="{{ route('admin.cinemas') }}"><i class="fas fa-solid fa-clapperboard"></i> Quản lý rạp</a></li>
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu và ghế</a></li>
            <li><a href="{{ route('admin.movies') }}" class="active"><i class="fas fa-film"></i> Quản lý phim</a></li>
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
        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table table-bordered" style="width: 100%;">
                <tr>
                    <th>Tiêu chí</th>
                    <th>Giá trị nhập</th>
                </tr>

                <tr>
                    <td>Tiêu đề phim</td>
                    <td><input type="text" name="title" class="form-control" required></td>
                </tr>

                <tr>
                    <td>Ngày chiếu</td>
                    <td>
                        <label>
                            <input type="date" name="release_date" class="form-control" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>Poster</td>
                    <td><input type="file" name="poster" class="form-control"></td>
                </tr>

                <tr>
                    <td>Tác giả</td>
                    <td><input type="text" name="author" class="form-control"></td>
                </tr>

                <tr>
                    <td>Thời lượng (phút)</td>
                    <td><input type="number" name="duration" class="form-control"></td>
                </tr>

                <tr>
                    <td>Ngôn ngữ</td>
                    <td><input type="text" name="language" class="form-control"></td>
                </tr>

                <tr>
                    <td>Phụ đề</td>
                    <td><input type="text" name="caption" class="form-control"></td>
                </tr>

                <tr>
                    <td>Mô tả</td>
                    <td><textarea name="description" class="form-control"></textarea></td>
                </tr>

                <tr>
                    <td>Bình luận</td>
                    <td><textarea name="comment" class="form-control"></textarea></td>
                </tr>

                <tr>
                    <td>Đánh giá (rating)</td>
                    <td><input type="number" name="rating" min="0" max="10" step="0.1" class="form-control"></td>
                </tr>

                <tr>
                    <td>Trailer (link embed youtube)</td>
                    <td><input type="text" name="trailer" class="form-control"></td>
                </tr>

                <tr>
                    <td>Thể loại phim</td>
                    <td>
                        <select name="genre_movie_id" class="form-control" required>
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">
                                    {{ $genre->genre_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" class="btn btn-primary">Thêm phim</button>
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </main>
</div>

</body>
</html>
