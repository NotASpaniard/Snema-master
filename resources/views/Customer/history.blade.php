@include('Customer.navbar')

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDCinema - Đặt vé xem phim trực tuyến</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e63946;
            --primary-dark: #d62839;
            --dark: #1a1a1a;
            --light: #f8f9fa;
            --gray: #6c757d;
            --dark-gray: #343a40;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f5f5;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Navbar - Keeping your original */
        .navbar {
            background: var(--dark);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary);
        }

        .navbar-nav .nav-link {
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        .btn-outline-light {
            border-color: white;
        }

        .btn-outline-light:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-danger {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-danger:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Hero Section */
        .hero {
            position: relative;
            overflow: hidden;
            background: none;
            min-height: 400px;
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            color: #fff;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .search-container {
            max-width: 600px;
            margin: 2rem auto 0;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: none;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 5px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: var(--primary-dark);
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary);
        }

        /* Movie Tabs */
        .movie-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .movie-tab {
            padding: 0.5rem 1.5rem;
            background: white;
            border: 1px solid #ddd;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .movie-tab.active,
        .movie-tab:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Movie Grid */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .movie-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .movie-poster {
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .movie-card:hover .movie-poster img {
            transform: scale(1.05);
        }

        .movie-info {
            padding: 1.2rem;
        }

        .movie-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .movie-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .movie-rating {
            color: #ffc107;
        }

        .book-btn {
            display: block;
            width: 100%;
            padding: 0.7rem;
            background: var(--primary);
            color: white;
            text-align: center;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .book-btn:hover {
            background: var(--primary-dark);
            color: white;
            text-decoration: none;
        }

        .countdown-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Promotions */
        .promo-section {
            margin: 4rem 0;
        }

        .promo-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .promo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .promo-content {
            padding: 1.5rem;
        }

        .promo-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .promo-desc {
            color: var(--gray);
            margin-bottom: 1rem;
        }

        /* Cinema Selector */
        .cinema-selector {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .cinema-selector label {
            font-weight: 600;
            margin-right: 1rem;
        }

        .cinema-selector select {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-width: 250px;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            display: inline-block;
        }

        .footer-about {
            margin-bottom: 1.5rem;
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.7rem;
        }

        .footer-links a {
            color: #adb5bd;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .newsletter-form {
            margin-top: 1.5rem;
        }

        .newsletter-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 5px;
            border: none;
            margin-bottom: 0.8rem;
        }

        .newsletter-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .newsletter-btn:hover {
            background: var(--primary-dark);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #adb5bd;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .movie-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }

            .hero h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .movie-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1.5rem;
            }

            .hero {
                padding: 3rem 0;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .movie-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .movie-tabs {
                justify-content: center;
            }

            .cinema-selector select {
                min-width: 200px;
            }
        }
    </style>
    <style>
        .transparent-modal {
            background-color: rgba(255, 255, 255, 0); /* Hoàn toàn trong suốt */
            backdrop-filter: blur(4px);               /* Tuỳ chọn: hiệu ứng làm mờ */
            box-shadow: none;                         /* Loại bỏ đổ bóng */
            border: none;                             /* Loại bỏ viền */
        }

        .list-group-item {
            background-color: transparent !important;
            border: none;
            padding: 6px 10px;
            color: white;
        }
    </style>
</head>

<body>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Hero Section -->
<section class="hero" style="position: relative; overflow: hidden; background: none;">
    <video autoplay loop muted playsinline
           style="position: absolute; width: 100%; height: 100%; object-fit: cover; left: 0; top: 0; z-index: 1;">
        <source src="{{ asset('storage/' . 'mot.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-overlay" style="background: rgba(0,0,0,0.6); z-index: 2;"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="marvel-text"
                style="font-size: 5rem; font-weight: bold; color: transparent; background: url('{{ asset('videos/Marvel Opening Theme.mp4') }}') no-repeat center center; background-size: cover; -webkit-background-clip: text; background-clip: text; -webkit-text-stroke: 2px #fff; text-stroke: 2px #fff; position: relative; z-index: 3;">
                TDCinema
            </h1>
            <p>Đặt vé trực tuyến dễ dàng, nhanh chóng và nhận nhiều ưu đãi hấp dẫn</p>
            <form action="{{ route('customers.index') }}" method="GET" class="mb-4">
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="main-content">
    <div class="container">

        <div class="d-flex justify-content-center align-items-center">
            <h1 class="text-center">Lịch sử đặt vé</h1>
        </div>

        <div class="booking-history mt-4">
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
                                    {{ \Carbon\Carbon::parse($booking->booking_details->first()->booking_time)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $booking->id }}">
                                    Xem vé
                                </button>

{{--                                Modal--}}
                                <div class="modal fade" id="modal-{{ $booking->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $booking->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content transparent-modal" style="background-image: url('{{ asset('images/ticket.png') }}'); background-size: auto; background-position: center;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-{{ $booking->id }}">Chi tiết vé xem phim</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group list-group-flush bg-transparent text-white">
                                                    <li class="list-group-item"><strong>Phim:</strong> {{ $booking->showtime->movie->title }}</li>
                                                    <li class="list-group-item">
                                                        <strong>Ngày đặt:</strong>
                                                        {{ \Carbon\Carbon::parse(optional($booking->booking_details->first())->booking_time ?? 'Không có dữ liệu')->format('d/m/Y') }}
                                                    </li>

                                                    <li class="list-group-item"><strong>Trạng thái:</strong> {{ $booking->status == '1' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</li>
                                                    <li class="list-group-item"><strong>Ghế:</strong>
                                                        @foreach ($booking->booking_details as $detail)
                                                            {{ $detail->seat->seat_code }}@if (!$loop->last), @endif
                                                        @endforeach
                                                    </li>
                                                    <li class="list-group-item"><strong>Phòng:</strong> {{ $booking->showtime->room->room_number }}</li>
                                                    <li class="list-group-item"><strong>Suất chiếu:</strong> {{ $booking->showtime->start_time }} - {{ $booking->showtime->end_time }}</li>
                                                    <li class="list-group-item"><strong>Rạp:</strong> {{ $booking->showtime->room->cinema->name }}</li>
                                                    <li class="list-group-item"><strong>Ngày chiếu:</strong> {{ \Carbon\Carbon::parse($booking->showtime->movie->release_date)->format('d/m/Y') }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Không có đơn hàng nào</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="footer-logo">TDCinema</div>
                <p class="footer-about">Hệ thống đặt vé xem phim trực tuyến hàng đầu Bình Nguyên Vô Tận, mang đến trải nghiệm điện ảnh tuyệt vời nhất.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
                <h3 class="footer-title">Liên kết</h3>
                <ul class="footer-links">
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Phim</a></li>
                    <li><a href="#">Rạp</a></li>
                    <li><a href="#">Khuyến mãi</a></li>
                    <li><a href="#">Tin tức</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
                <h3 class="footer-title">Hỗ trợ</h3>
                <ul class="footer-links">
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Hướng dẫn đặt vé</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h3 class="footer-title">Đăng ký nhận tin</h3>
                <p>Nhận thông tin về phim mới, khuyến mãi đặc biệt và nhiều hơn nữa.</p>

                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Email của bạn" required>
                    <button type="submit" class="newsletter-btn">Đăng ký</button>
                </form>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2025 TDCinema. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>
</html>
