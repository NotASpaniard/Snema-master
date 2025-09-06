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
        <div class="container">
            <h2 class="mb-4">Sửa thông tin phim</h2>

            <form action="{{ route('movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tiêu đề phim --}}
                <div class="mb-3">
                    <label class="form-label">Tên phim</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" required>
                </div>

                {{-- Ngày chiếu --}}
                <div class="mb-3">
                    <label class="form-label">Ngày phát hành</label>
                    <input type="date" name="release_date" class="form-control" value="{{ old('release_date', $movie->release_date) }}" min="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                </div>

                {{-- Poster --}}
                <div class="mb-3">
                    <label class="form-label">Poster (nếu muốn thay)</label><br>
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" width="100" class="mb-2"><br>
                    @endif
                    <input type="file" name="poster" class="form-control">
                </div>

                {{-- Tác giả, ngôn ngữ, mô tả, rating --}}
                <div class="mb-3">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $movie->author) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thời lượng (phút)</label>
                    <input type="number" name="duration" class="form-control" value="{{ old('duration', $movie->duration) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngôn ngữ</label>
                    <input type="text" name="language" class="form-control" value="{{ old('language', $movie->language) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phụ đề</label>
                    <input type="text" name="caption" class="form-control" value="{{ old('caption', $movie->caption) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $movie->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Đánh giá (tối đa 10)</label>
                    <input type="number" step="0.1" name="rating" class="form-control" value="{{ old('rating', $movie->rating) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Trailer (link embed youtube)</label>
                    <input type="text" name="trailer" class="form-control" value="{{ old('trailer', $movie->trailer) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thể loại</label>
                    <select name="genre_movie_id" class="form-select" required>
                        <option value="">-- Chọn thể loại --</option>
                        @foreach ($genre_movies as $genre_movie)
                            <option value="{{ $genre_movie->id }}"
                                {{ $genre_movie->id == $movie->genre_movie_id ? 'selected' : '' }}>
                                {{ $genre_movie->genre->genre_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.movies') }}" class="btn btn-secondary">Huỷ</a>
            </form>
        </div>
</div>

</body>
</html>
