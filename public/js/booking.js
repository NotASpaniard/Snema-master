// booking.js - Xử lý chức năng đặt vé


document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.seat-checkbox');
    const selectedSeatsDisplay = document.getElementById('selected-seats');

    checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
    const label = this.parentElement;

    if (this.checked) {
        label.classList.add('bg-green-500');
    } else {
        label.classList.remove('bg-green-500');
    }

    const selected = Array.from(checkboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.closest('label').innerText.trim());

    selectedSeatsDisplay.innerText = selected.join(', ');
        });
    });
});


// Code cũ
// document.addEventListener('DOMContentLoaded', function() {
//     // Chỉ chạy trên trang đặt vé
//     if (!document.querySelector('.booking-container')) return;
//
//     // Khởi tạo dữ liệu ghế
//     const rows = ['A', 'B', 'C', 'D', 'E', 'F'];
//     const seatsPerRow = 10;
//     const bookedSeats = ['A1', 'A2', 'B5', 'C7', 'D3', 'E8', 'F10'];
//     let selectedSeats = [];
//     const seatPrice = 75000;
//
//     // Tạo lưới ghế
//     const seatsGrid = document.getElementById('seatsGrid');
//     rows.forEach(row => {
//         for (let i = 1; i <= seatsPerRow; i++) {
//             const seatId = `${row}${i}`;
//             const isBooked = bookedSeats.includes(seatId);
//
//             const seat = document.createElement('div');
//             seat.className = `seat ${isBooked ? 'booked' : 'available'}`;
//             seat.dataset.seatId = seatId;
//             seat.textContent = i;
//
//             if (!isBooked) {
//                 seat.addEventListener('click', toggleSeatSelection);
//             }
//
//             seatsGrid.appendChild(seat);
//         }
//     });
//
//     // Xử lý chọn ghế
//     function toggleSeatSelection(e) {
//         const seat = e.target;
//         const seatId = seat.dataset.seatId;
//
//         if (seat.classList.contains('selected')) {
//             seat.classList.remove('selected');
//             selectedSeats = selectedSeats.filter(id => id !== seatId);
//         } else {
//             seat.classList.add('selected');
//             selectedSeats.push(seatId);
//         }
//
//         updateBookingSummary();
//     }
//
//     // Cập nhật thông tin đặt vé
//     function updateBookingSummary() {
//         const selectedSeatsList = document.getElementById('selectedSeatsList');
//         const totalPriceElement = document.getElementById('totalPrice');
//         const proceedButton = document.getElementById('proceedButton');
//
//         selectedSeatsList.innerHTML = '';
//         selectedSeats.forEach(seatId => {
//             const li = document.createElement('li');
//             li.textContent = seatId;
//             selectedSeatsList.appendChild(li);
//         });
//
//         const totalPrice = selectedSeats.length * seatPrice;
//         totalPriceElement.textContent = `${totalPrice.toLocaleString()} đ`;
//
//         proceedButton.disabled = selectedSeats.length === 0;
//     }
//
//     // Xử lý nút tiếp tục
//     document.getElementById('proceedButton').addEventListener('click', function() {
//         // Lưu thông tin đặt vé vào localStorage hoặc sessionStorage
//         sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
//         sessionStorage.setItem('totalPrice', selectedSeats.length * seatPrice);
//
//         // Chuyển đến trang thanh toán
//         window.location.href = 'payment.html';
//     });
// });
