document.addEventListener('DOMContentLoaded', function() {
    // Có thể thêm hiệu ứng load phim từ API
    const movieGrid = document.querySelector('.movie-grid');

    // Giả lập dữ liệu phim
    const movies = [{
            title: "Avengers: Endgame",
            image: "images/movie1.jpg",
            rating: 8.5,
            duration: "181 phút",
            description: "Nhóm Avengers tập hợp lần cuối để đảo ngược hành động của Thanos."
        },
        // Thêm các phim khác...
    ];

    // Render phim (nếu dùng JS để load)
    movies.forEach(movie => {
        const movieCard = document.createElement('div');
        movieCard.className = 'movie-card';
        movieCard.innerHTML = `
        <img src="${movie.image}" alt="${movie.title}" class="movie-poster">
        <div class="movie-overlay">
          <h3>${movie.title}</h3>
          <div class="movie-details">
            <span class="rating"><i class="fas fa-star"></i> ${movie.rating}</span>
            <span class="duration">${movie.duration}</span>
            <p class="description">${movie.description}</p>
            <button class="book-btn">Đặt vé</button>
          </div>
        </div>
      `;
        movieGrid.appendChild(movieCard);
    });
});