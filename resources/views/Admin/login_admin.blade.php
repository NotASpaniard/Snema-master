<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snema - Đăng nhập/Đăng ký</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
</head>

<body>
<div class="container">
    <div class="form-box login">
        <form method="POST" action="{{ route('admin.loginProcess') }}">
            @csrf
            <h1>Administrator</h1>

            @if ($errors->any())
                <div style="color:red;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="forgot-link">
                <a href="#">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn">Đăng nhập</button>
            <p>hoặc đăng nhập bằng</p>
            <div class="social-icons">
                <a href="#"><i class='bx bxl-google'></i></a>
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-github'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>
        </form>
    </div>

        <div class="toggle-panel toggle-right">
            <h1>Chào mừng trở lại!</h1>
            <p>Bạn đã có tài khoản?</p>
            <button class="btn login-btn">Đăng nhập</button>
        </div>
    </div>
</div>

<script>
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');
    const colorThief = new ColorThief();

    // Hàm chuyển đổi RGB sang hex
    function rgbToHex(r, g, b) {
        return '#' + [r, g, b].map(x => {
            const hex = x.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }).join('');
    }

    // Hàm tính độ sáng để xác định màu chữ
    function getLuminance(r, g, b) {
        return (0.299 * r + 0.587 * g + 0.114 * b) / 255;
    }

    // Hàm cập nhật màu sắc
    function updateColors() {
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.src = './images/t.jpg';

        img.onload = function() {
            const dominantColor = colorThief.getColor(img);
            const [r, g, b] = dominantColor;

            // Cập nhật biến CSS
            document.documentElement.style.setProperty('--primary-color', rgbToHex(r, g, b));
            document.documentElement.style.setProperty('--primary-rgb', `${r}, ${g}, ${b}`);

            // Cập nhật màu chữ dựa trên độ sáng
            const luminance = getLuminance(r, g, b);
            const textColor = luminance > 0.5 ? '#000' : '#fff';

            // Áp dụng màu chữ cho các phần tử
            document.querySelectorAll('.toggle-panel').forEach(panel => {
                panel.style.color = textColor;
            });
        };
    }

    // Gọi hàm cập nhật màu khi trang tải xong
    window.addEventListener('load', updateColors);

    registerBtn.addEventListener('click', () => {
        container.classList.add('active');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove('active');
    });
</script>
</body>

</html>
