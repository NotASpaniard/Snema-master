@include('Customer.navbar')

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi - TDCinema</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f6f7fb;
            color: #222;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding-top: 60px;
        }
        .navbar {
            background: #181818;
            color: #fff;
            padding: 0.8rem 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ff4d4d;
            text-decoration: none;
            transition: color 0.2s;
        }
        .logo:hover {
            color: #e43c3c;
        }
        nav {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        nav a.active, nav a:hover {
            background: #ff4d4d;
            color: #fff;
        }
        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .auth-buttons a {
            color: #fff;
            background: #ff4d4d;
            border-radius: 4px;
            padding: 0.5rem 1.2rem;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        .auth-buttons a.login-btn {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }
        .auth-buttons a:hover {
            background: #e43c3c;
        }
        .auth-buttons a.register-btn {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }
        .main-content {
            display: flex;
            gap: 2rem;
            margin: 2rem auto;
            max-width: 1400px;
            padding: 0 1rem;
        }
        .ad-sidebar {
            width: 200px;
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .content-area {
            flex: 1;
        }
        .main-title { text-align: center; margin: 2.5rem 0 1.5rem 0; font-size: 2.2rem; color: #ff4d4d; }
        .about-section { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin-bottom: 2.5rem; padding: 2.5rem 2rem; }
        .about-section h2 { color: #ff4d4d; margin-bottom: 1.2rem; }
        .about-content { display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; justify-content: center; }
        .about-text { flex: 1 1 300px; font-size: 1.1rem; color: #444; }
        .about-image { flex: 1 1 300px; display: flex; align-items: center; justify-content: center; }
        .about-image img { width: 320px; height: 200px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .value-list { display: flex; gap: 2rem; margin-top: 2rem; }
        .value-item { background: #f8f8f8; border-radius: 10px; padding: 1.5rem; flex: 1; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .value-item i { font-size: 2.2rem; color: #ff4d4d; margin-bottom: 0.7rem; }
        .team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 2rem; }
        .team-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center; padding: 1.5rem 1rem; }
        .team-card img { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; background: #ececec; }
        .team-card h4 { margin-bottom: 0.3rem; color: #ff4d4d; }
        .team-card p { color: #888; font-size: 0.95rem; }
        .partner-logos { display: flex; gap: 2rem; justify-content: center; align-items: center; margin: 2.5rem 0; flex-wrap: wrap; }
        .partner-logo { width: 120px; height: 60px; background: #ececec; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #bbb; }
        .contact-section { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 2rem; margin-bottom: 2.5rem; }
        .contact-section h2 { color: #ff4d4d; margin-bottom: 1.2rem; }
        .contact-info { font-size: 1.1rem; color: #444; line-height: 2; }
        @media (max-width: 900px) { .about-content, .value-list { flex-direction: column; } .team-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 600px) { .team-grid { grid-template-columns: 1fr; } }
        .cinema-floating-box {
            animation: floatY 2.5s ease-in-out infinite alternate;
        }
        @keyframes floatY {
            0% { transform: translateY(0); }
            100% { transform: translateY(-20px); }
        }

        /* Animation Background Styles */
        #animated-bg {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="content-area">
            <div class="main-title">Về chúng tôi</div>
            <section class="about-section">
                <h2>Sứ mệnh của TDCinema</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>TDCinema ra đời với sứ mệnh mang đến trải nghiệm điện ảnh hiện đại, tiện lợi và thân thiện nhất cho mọi khách hàng. Chúng tôi không ngừng đổi mới để giúp bạn đặt vé, chọn rạp, chọn ghế và nhận ưu đãi một cách dễ dàng nhất.</p>
                    </div>
                    <div class="about-image">
                        <img src="{{ asset('storage/' . 'banner.jpg') }}" alt="Sứ mệnh TDCinema">
                    </div>
                </div>
            </section>

            <section class="about-section">
                <h2>Giá trị cốt lõi</h2>
                <div class="value-list">
                    <div class="value-item">
                        <i class="fa-solid fa-bolt"></i>
                        <h4>Nhanh chóng</h4>
                        <p>Đặt vé, thanh toán và nhận vé chỉ trong vài bước đơn giản.</p>
                    </div>
                    <div class="value-item">
                        <i class="fa-solid fa-shield-heart"></i>
                        <h4>An toàn</h4>
                        <p>Bảo mật thông tin, thanh toán an toàn, hỗ trợ khách hàng tận tâm.</p>
                    </div>
                    <div class="value-item">
                        <i class="fa-solid fa-gift"></i>
                        <h4>Ưu đãi</h4>
                        <p>Liên tục cập nhật các chương trình khuyến mãi hấp dẫn cho khách hàng.</p>
                    </div>
                </div>
            </section>

            <section class="contact-section">
                <h2>Liên hệ</h2>
                <div class="contact-info">
                    <p><i class="fa-solid fa-envelope"></i> Email: tdcine@cinema.com</p>
                    <p><i class="fa-solid fa-phone"></i> Điện thoại: 1900 1234</p>
                    <p><i class="fa-solid fa-location-dot"></i> Địa chỉ: Hà Nội</p>
                </div>
            </section>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>Hệ thống rạp chiếu phim hàng đầu Việt Nam</p>
            </div>
            <div class="footer-section">
                <h3>Liên kết</h3>
                <ul>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <p>Email: tdcine@cinema.com</p>
                <p>Điện thoại: 1900 1234</p>
            </div>
        </div>
        <div class="copyright">
            <p>© 2025 - TDCinema - Xem phim thôi nào!</p>
        </div>
    </footer>

    <!-- Animated Background -->
    <canvas id="animated-bg" width="32" height="32"></canvas>

    <script>
        var c = document.getElementById('animated-bg');
        var $ = c.getContext('2d');

        var col = function(x, y, r, g, b) {
            $.fillStyle = "rgb(" + r + "," + g + "," + b + ")";
            $.fillRect(x, y, 1,1);
        }

        var R = function(x, y, t) {
            return( Math.floor(192 + 64*Math.cos( (x*x-y*y)/300 + t )) );
        }

        var G = function(x, y, t) {
            return( Math.floor(192 + 64*Math.sin( (x*x*Math.cos(t/4)+y*y*Math.sin(t/3))/300 ) ) );
        }

        var B = function(x, y, t) {
            return( Math.floor(192 + 64*Math.sin( 5*Math.sin(t/9) + ((x-100)*(x-100)+(y-100)*(y-100))/1100) ));
        }

        var t = 0;

        var run = function() {
            for(x=0;x<=35;x++) {
                for(y=0;y<=35;y++) {
                    col(x, y, R(x,y,t), G(x,y,t), B(x,y,t));
                }
            }
            t = t + 0.120;
            window.requestAnimationFrame(run);
        }

        run();
    </script>
</body>
</html>
