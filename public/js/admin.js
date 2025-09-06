// admin.js - JavaScript cho khu vực quản trị

document.addEventListener('DOMContentLoaded', function() {
    // Chỉ chạy trong khu vực quản trị
    if (!document.querySelector('.admin-container')) return;

    // Xử lý menu active
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.admin-nav a');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });

    // Xử lý đăng xuất
    document.querySelector('.logout-btn') ?.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Bạn có chắc chắn muốn đăng xuất?')) {
            window.location.href = '../login.html';
        }
    });

    // Khởi tạo biểu đồ nếu có trên trang
    if (document.getElementById('revenueChart')) {
        initCharts();
    }
});

// Khởi tạo biểu đồ
function initCharts() {
    // Biểu đồ doanh thu
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh thu (triệu đồng)',
                data: [12, 19, 15, 22, 18, 25],
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Biểu đồ phim có doanh thu cao nhất
    const topMoviesCtx = document.getElementById('topMoviesChart').getContext('2d');
    const topMoviesChart = new Chart(topMoviesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Avengers: Endgame', 'Spider-Man: No Way Home', 'The Batman', 'Dune', 'Black Panther'],
            datasets: [{
                data: [35, 25, 15, 10, 8],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Hàm xử lý upload ảnh
async function handleImageUpload(file, type) {
    try {
        const formData = new FormData();
        formData.append('image', file);

        const response = await fetch(`/api.php?action=upload-image&type=${type}`, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Upload failed');
        }

        const result = await response.json();
        if (result.success) {
            return result.data.path;
        } else {
            throw new Error(result.error || 'Upload failed');
        }
    } catch (error) {
        console.error('Error uploading image:', error);
        alert('Lỗi khi tải lên ảnh: ' + error.message);
        throw error;
    }
}

// Hàm xử lý thêm mới
async function handleAdd(type, data) {
    try {
        const response = await fetch(`/api.php?type=${type}&action=add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Add failed');
        }

        const result = await response.json();
        if (result.success) {
            alert(result.message);
            return result.data;
        } else {
            throw new Error(result.error || 'Add failed');
        }
    } catch (error) {
        console.error(`Error adding ${type}:`, error);
        alert(`Lỗi khi thêm ${type}: ` + error.message);
        throw error;
    }
}

// Hàm xử lý cập nhật
async function handleUpdate(type, id, data) {
    try {
        const response = await fetch(`/api.php?type=${type}&id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Update failed');
        }

        const result = await response.json();
        if (result.success) {
            alert(result.message);
            return result.data;
        } else {
            throw new Error(result.error || 'Update failed');
        }
    } catch (error) {
        console.error(`Error updating ${type}:`, error);
        alert(`Lỗi khi cập nhật ${type}: ` + error.message);
        throw error;
    }
}

// Hàm xử lý xóa
async function handleDelete(type, id) {
    if (!confirm('Bạn có chắc chắn muốn xóa?')) {
        return;
    }

    try {
        const response = await fetch(`/api.php?type=${type}&id=${id}`, {
            method: 'DELETE'
        });

        if (!response.ok) {
            throw new Error('Delete failed');
        }

        const result = await response.json();
        if (result.success) {
            alert(result.message);
            // Reload trang sau khi xóa thành công
            window.location.reload();
        } else {
            throw new Error(result.error || 'Delete failed');
        }
    } catch (error) {
        console.error(`Error deleting ${type}:`, error);
        alert(`Lỗi khi xóa ${type}: ` + error.message);
    }
}

// Hàm xử lý submit form
async function handleFormSubmit(event, type) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const data = {};

    // Xử lý upload ảnh nếu có
    const imageFile = formData.get('image');
    if (imageFile && imageFile.size > 0) {
        try {
            const imagePath = await handleImageUpload(imageFile, type);
            data.image = imagePath;
        } catch (error) {
            return;
        }
    }

    // Lấy các trường dữ liệu khác
    for (let [key, value] of formData.entries()) {
        if (key !== 'image') {
            data[key] = value;
        }
    }

    try {
        const id = form.dataset.id;
        if (id) {
            await handleUpdate(type, id, data);
        } else {
            await handleAdd(type, data);
        }
        closeModal(type);
        window.location.reload();
    } catch (error) {
        console.error('Error submitting form:', error);
    }
}

// Hàm mở modal với dữ liệu
function openModalWithData(type, data = null) {
    const modal = document.getElementById(`${type}Modal`);
    const form = document.getElementById(`${type}Form`);
    const title = modal.querySelector('h2');

    // Reset form
    form.reset();
    form.dataset.id = '';

    if (data) {
        // Điền dữ liệu vào form
        title.textContent = 'Chỉnh sửa thông tin';
        form.dataset.id = data.id;
        for (let key in data) {
            const input = form.elements[key];
            if (input) {
                if (input.type === 'file') {
                    // Không điền giá trị cho input file
                    continue;
                }
                input.value = data[key];
            }
        }
    } else {
        title.textContent = 'Thêm mới';
    }

    modal.style.display = 'block';
}

// Hàm đóng modal
function closeModal(type) {
    const modal = document.getElementById(`${type}Modal`);
    modal.style.display = 'none';
}

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let modal of modals) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}
