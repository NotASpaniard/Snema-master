//JavaScript chung cho toàn bộ trang

// Khởi tạo khi DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý menu active
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });

    // Xử lý nút đăng nhập/đăng ký (nếu có trên trang)
    const loginBtn = document.querySelector('.login-btn');
    const registerBtn = document.querySelector('.register-btn');

    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            if (!this.tagName === 'A') {
                e.preventDefault();
                window.location.href = 'login.html';
            }
        });
    }

    if (registerBtn) {
        registerBtn.addEventListener('click', function(e) {
            if (!this.tagName === 'A') {
                e.preventDefault();
                window.location.href = 'register.html';
            }
        });
    }

    // Load dữ liệu phim (nếu có trên trang)
    if (document.querySelector('.movie-slider')) {
        loadFeaturedMovies();
    }

    // Load dữ liệu rạp (nếu có trên trang)
    if (document.querySelector('.cinema-grid')) {
        loadFeaturedCinemas();
    }
});

// Hàm load phim nổi bật
function loadFeaturedMovies() {
    setTimeout(() => {
        const movies = [
            { id: 1, title: 'Avengers: Endgame', rating: 8.5, image: 'images/movie1.jpg' },
            { id: 2, title: 'Spider-Man: No Way Home', rating: 8.2, image: 'images/movie2.jpg' },
            { id: 3, title: 'The Batman', rating: 7.9, image: 'images/movie3.jpg' },
            { id: 4, title: 'Dune', rating: 8.0, image: 'images/movie4.jpg' }
        ];

        const slider = document.querySelector('.movie-slider');
        slider.innerHTML = '';

        movies.forEach(movie => {
            const movieCard = document.createElement('div');
            movieCard.className = 'movie-card';
            movieCard.innerHTML = `
                <img src="${movie.image}" alt="${movie.title}">
                <div class="movie-info">
                    <h3>${movie.title}</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i> ${movie.rating}/10
                    </div>
                    <a href="movie-detail.html?id=${movie.id}" class="book-btn">Chi tiết</a>
                </div>
            `;
            slider.appendChild(movieCard);
        });
    }, 500);
}

// Hàm load rạp nổi bật
function loadFeaturedCinemas() {
    setTimeout(() => {
        const cinemas = [
            { id: 1, name: 'CGV Hùng Vương Plaza', location: 'Quận 5, TP.HCM' },
            { id: 2, name: 'Lotte Cinema Đà Nẵng', location: 'Quận Hải Châu, Đà Nẵng' },
            { id: 3, name: 'BHD Star Phạm Hùng', location: 'Quận 8, TP.HCM' },
            { id: 4, name: 'Galaxy Nguyễn Du', location: 'Quận 1, TP.HCM' }
        ];

        const grid = document.querySelector('.cinema-grid');
        grid.innerHTML = '';

        cinemas.forEach(cinema => {
            const cinemaCard = document.createElement('div');
            cinemaCard.className = 'cinema-card';
            cinemaCard.innerHTML = `
                <div class="cinema-image">
                    <img src="images/cinema${cinema.id}.jpg" alt="${cinema.name}">
                </div>
                <div class="cinema-info">
                    <h3>${cinema.name}</h3>
                    <p>${cinema.location}</p>
                    <a href="cinemas.html?id=${cinema.id}" class="view-btn">Xem chi tiết</a>
                </div>
            `;
            grid.appendChild(cinemaCard);
        });
    }, 500);
}