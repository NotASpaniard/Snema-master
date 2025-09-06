@include('Customer.navbar')

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avengers: Endgame - Snema</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movie-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Movie Detail Section */
        .movie-detail-section {
            padding: 3rem 0;
        }

        .movie-poster {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .movie-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .movie-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .movie-meta-item i {
            color: var(--primary);
        }

        .movie-rating {
            background: var(--primary);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .movie-rating i {
            color: white;
        }

        .movie-description {
            margin: 2rem 0;
        }

        .movie-description h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .movie-description p {
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .movie-cast-crew {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .movie-cast-crew-item h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .movie-cast-crew-item p {
            color: var(--gray);
        }

        /* Showtimes Section */
        .showtimes-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 3rem;
        }

        .showtimes-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark);
            position: relative;
        }

        .showtimes-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary);
        }

        .cinema-filter {
            margin-bottom: 2rem;
        }

        .cinema-filter label {
            font-weight: 600;
            margin-right: 1rem;
        }

        .cinema-filter select {
            padding: 0.7rem 1rem;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-width: 300px;
        }

        .showtime-format {
            margin-bottom: 2rem;
        }

        .showtime-format h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .showtime-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .showtime-btn {
            padding: 0.7rem 1.5rem;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .showtime-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .showtime-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Trailer Section */
        .trailer-section {
            margin-bottom: 3rem;
        }

        .trailer-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .trailer-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Gallery Section */
        .gallery-section {
            margin-bottom: 3rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 8px;
            overflow: hidden;
            height: 180px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Reviews Section */
        .reviews-section {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 3rem;
        }

        .review-card {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            margin-bottom: 1.5rem;
        }

        .review-card:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #eee;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            font-weight: 600;
        }

        .review-user {
            flex: 1;
        }

        .review-user h5 {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .review-date {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .review-rating {
            color: #ffc107;
        }

        .review-content {
            line-height: 1.7;
        }

        /* Promotion Banner */
        .promotion-banner {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 3rem;
            text-align: center;
        }

        .promotion-banner h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .promotion-banner p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .promotion-btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: white;
            color: var(--primary);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .promotion-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: var(--primary-dark);
            text-decoration: none;
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
            .movie-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .movie-meta {
                gap: 1rem;
            }

            .movie-title {
                font-size: 1.8rem;
            }

            .showtime-list {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .movie-title {
                font-size: 1.6rem;
            }

            .movie-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .cinema-filter select {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Movie Detail Section -->
    <div class="movie-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="movie-poster">
                        <img src="{{ asset('storage/' . $movies->poster) }}" alt="{{ $movies->title }}">
                    </div>
                </div>
                <div class="col-lg-8">
                    <h1 class="movie-title">{{ $movies->title }}</h1>

                    <div class="movie-meta">
                        <span class="movie-rating">
                            <i class="fas fa-star"></i> {{ $movies->rating }} / 10
                        </span>
                        <span class="movie-meta-item">
                            <i class="fas fa-clock"></i> {{ $movies->duration }} phút
                        </span>
                        <span class="movie-meta-item">
                            <i class="fas fa-film"></i> {{ $movies->genre_movie->genre->genre_name }}
                        </span>
                        <span class="movie-meta-item">
                            <i class="fas fa-calendar-alt"></i> {{ $movies->release_date }}
                        </span>
                    </div>

                    <div class="movie-description">
                        <h3>Nội dung phim</h3>
                        <p>{{ $movies->description }}</p>
                    </div>

                    <div class="movie-cast-crew">
                        <div class="movie-cast-crew-item">
                            <h4>Đạo diễn</h4>
                            <p>{{ $movies->author }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Showtimes Section -->
    <section class="showtimes-section" id="showtimes">
        <div class="container">
            <h2 class="showtimes-title">Lịch chiếu</h2>

            <div class="cinema-filter">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="cinema-select">Chọn rạp:</label>
                    </div>
                    <div class="col-md-9">
                        <select id="cinema-select" class="form-select">
                            @foreach($cinemas as $cinema)
                              <option value="{{ $cinema->id }}">{{ $cinema->name }} - {{ $cinema->location->location_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4">Suất chiếu</h4>

        <form method="GET" action="{{ route('bookings.create') }}">
            @csrf

            <label for="showtime_id">Chọn suất chiếu:</label>

            @php
                use Carbon\Carbon;

                $now = Carbon::now();
            @endphp

            @foreach ($showtimes as $showtime)
                @php
                    $release_date = Carbon::parse($movies->release_date);
                    $start_time   = Carbon::parse($showtime->start_time);
                    $can_book = true;

//                    if ($release_date->isFuture()) {
//                        $can_book = true;
//                    }

                    // Cấm nếu hôm nay và đã quá giờ chiếu
                    if ($release_date->isToday() && $start_time->lessThan($now)) {
                        $can_book = false;
                    }

                    // Cấm nếu release_date đã là quá khứ
                    if ($release_date->isPast() && !$release_date->isToday()) {
                        $can_book = false;
                    }
                @endphp

                <div class="mb-3 border p-2 rounded">
                    <p id="{{ $showtime->id }}"><strong>Suất chiếu:</strong>
                        {{ $start_time->format('H:i') }} - {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}
                    </p>

                    @if ($can_book)
                        <a href="{{ route('bookings.create', ['movie_id' => $movies->id, 'showtime_id' => $showtime->id]) }}"
                           class="btn btn-success">
                            Đặt vé
                        </a>
                    @else
                        <span class="text-muted">Không thể đặt vé (quá giờ hoặc đã chiếu)</span>
                    @endif
                </div>
            @endforeach
        </form>
    </section>

    <!-- Trailer Section -->
    <section class="trailer-section">
        <div class="container">
            <h2 class="showtimes-title">Trailer</h2>
            <div class="trailer-container">
                <iframe src="{{ $movies->trailer }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-logo">Snema</div>
                    <p class="footer-about">Hệ thống đặt vé xem phim trực tuyến hàng đầu Việt Nam, mang đến trải nghiệm điện ảnh tuyệt vời nhất.</p>
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
                <p>&copy; 2025 Snema. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/booking.js') }}"></script>
</body>
</html>
