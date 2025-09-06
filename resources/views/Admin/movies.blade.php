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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
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
                <li><a href="{{ route('admin.movies') }}" class="active"><i class="fas fa-film"></i> Quản lý phim</a></li>
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
            <div class="page-header">
                <h1 class="page-title">Quản lý phim</h1>
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> <a href="{{ route('movies.create') }}" style="color: white">Thêm phim</a>
                </button>
            </div>

            <div class="movie-slider row">
                @foreach($movies as $movie)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $movie->poster) }}" class="card-img-top" alt="{{ $movie->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $movie->title }}</h5>
                                <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                                <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Xoá</button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
        </main>

    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
