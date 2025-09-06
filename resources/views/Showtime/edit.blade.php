<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý giờ chiếu - Admin Panel</title>
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
            <li><a href="{{ route('admin.cinemas') }}}"><i class="fas fa-solid fa-clapperboard"></i> Quản lý rạp</a></li>
            <li><a href="{{ route('admin.rooms') }}"><i class="fas fa-solid fa-house"></i> Quản lý phòng chiếu</a></li>
            <li><a href="{{ route('admin.movies') }}"><i class="fas fa-film"></i> Quản lý phim</a></li>
            <li><a href="{{ route('admin.showtimes') }}" class="active"><i class="fas fa-solid fa-clock"></i> Quản lý giờ chiếu</a></li>
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
            <h1 class="page-title">Trang quản trị</h1>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-primary">
                    <i class="fas fa-sign-out"></i> Đăng xuất
                </button>
            </form>
        </div>

        <div class="col-md-3 mb-4">
            <form action="{{ route('showtimes.update', $showtime->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="movie_id" class="form-label">Phim:</label>
                    <select name="movie_id" id="movie_id" class="form-select" required>
                        @foreach ($movies as $movie)
                            <option value="{{ $movie->id }}" data-duration="{{ $movie->duration }}"
                                {{ $movie->id == $showtime->movie_id ? 'selected' : '' }}>
                                {{ $movie->title }} ({{ $movie->duration }} phút)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="start_time" class="form-label">Giờ bắt đầu:</label>
                    <input type="time" name="start_time" id="start_time" value="{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="room_id" class="form-label">Phòng chiếu:</label>
                    <select name="room_id" class="form-select" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id == $showtime->room_id ? 'selected' : '' }}>
                                {{ $room->room_number }} - {{ $room->cinema->name }} - {{ $room->cinema->location->location_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giờ kết thúc (tự động):</label>
                    <input type="text" class="form-control" id="end_time_preview" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá cộng thêm (tự động):</label>
                    <input type="text" class="form-control" id="extra_price_preview" disabled>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái:</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $showtime->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $showtime->status == 0 ? 'selected' : '' }}>Tạm ngưng</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a href="{{ route('admin.showtimes') }}" class="btn btn-secondary">Quay lại</a>
            </form>

        </div>
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
<script>
    const movieSelect = document.getElementById('movie_id');
    const startInput = document.getElementById('start_time');
    const endPreview = document.getElementById('end_time_preview');
    const extraPreview = document.getElementById('extra_price_preview');

    function updatePreview() {
        const duration = parseInt(movieSelect.options[movieSelect.selectedIndex].dataset.duration || 0);
        const start = startInput.value;

        if (duration && start) {
            const [h, m] = start.split(':');
            const startTime = new Date();
            startTime.setHours(+h, +m, 0);

            const endTime = new Date(startTime.getTime() + duration * 60000);
            const eh = String(endTime.getHours()).padStart(2, '0');
            const em = String(endTime.getMinutes()).padStart(2, '0');
            endPreview.value = `${eh}:${em}`;

            extraPreview.value = (parseInt(h) >= 16 && parseInt(h) < 22) ? '10.000 đ' : '0 đ';
        } else {
            endPreview.value = '';
            extraPreview.value = '';
        }
    }

    movieSelect.addEventListener('change', updatePreview);
    startInput.addEventListener('change', updatePreview);

    // Khởi động sẵn preview
    window.onload = updatePreview;
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script>
    const movieSelect = document.getElementById('movie_id');
    const startTimeInput = document.getElementById('start_time');
    const endTimePreview = document.getElementById('end_time_preview');
    const extraPricePreview = document.getElementById('extra_price_preview');
    const roomSelect = document.getElementById('room_id');
    const conflictAlert = document.getElementById('conflict-alert');
    const form = document.getElementById('showtime-form');

    function updatePreviewAndCheckConflict() {
        const movieOption = movieSelect.options[movieSelect.selectedIndex];
        const duration = parseInt(movieOption.dataset.duration || 0);
        const startTime = startTimeInput.value;
        const roomId = roomSelect.value;

        if (startTime && duration) {
            const [hours, minutes] = startTime.split(':').map(Number);
            const start = new Date();
            start.setHours(hours);
            start.setMinutes(minutes);

            const end = new Date(start.getTime() + duration * 60000);
            const endTimeStr = end.toTimeString().slice(0, 5);
            endTimePreview.value = endTimeStr;

            const hour = hours;
            extraPricePreview.value = (hour >= 12 && hour < 18) ? '10.000 đ' : '0 đ';

            // Gửi AJAX kiểm tra xung đột
            if (roomId) {
                fetch(`{{ route('showtimes.checkConflict') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        start_time: startTime,
                        duration: duration,
                        room_id: roomId
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.conflict) {
                            conflictAlert.classList.remove('d-none');
                            form.querySelector('button[type="submit"]').disabled = true;
                        } else {
                            conflictAlert.classList.add('d-none');
                            form.querySelector('button[type="submit"]').disabled = false;
                        }
                    });
            }
        } else {
            endTimePreview.value = '';
            extraPricePreview.value = '';
            conflictAlert.classList.add('d-none');
            form.querySelector('button[type="submit"]').disabled = false;
        }
    }

    movieSelect.addEventListener('change', updatePreviewAndCheckConflict);
    startTimeInput.addEventListener('change', updatePreviewAndCheckConflict);
    roomSelect.addEventListener('change', updatePreviewAndCheckConflict);
</script>
</body>
</html>
