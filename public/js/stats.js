document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['1/6', '2/6', '3/6', '4/6', '5/6', '6/6', '7/6'],
            datasets: [{
                label: "Doanh Thu",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [4500000, 5200000, 6800000, 7300000, 8900000, 7500000, 8200000],
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + ' ₫';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' ₫';
                        }
                    },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            }
        }
    });
    // Time Slot Chart
    var timeSlotCtx = document.getElementById('timeSlotChart').getContext('2d');
    var timeSlotChart = new Chart(timeSlotCtx, {
        type: 'doughnut',
        data: {
            labels: ["9:00-12:00", "12:00-15:00", "15:00-18:00", "18:00-21:00"],
            datasets: [{
                data: [15, 25, 30, 30],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            cutout: '70%',
        },
    });
    // Filter Form Submission
    document.getElementById('statsFilterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Here you would typically make an AJAX call to get filtered data
        console.log('Filter applied:', {
            movie: document.getElementById('movieSelect').value,
            dateFrom: document.getElementById('dateFrom').value,
            dateTo: document.getElementById('dateTo').value
        });
        // Then update charts with new data
    });
    // Export Buttons
    document.getElementById('exportPdf').addEventListener('click', function() {
        alert('Xuất PDF thành công!');
    });
    document.getElementById('exportExcel').addEventListener('click', function() {
        alert('Xuất Excel thành công!');
    });
    // Chart View Toggle
    document.getElementById('showRevenueByDay').addEventListener('click', function(e) {
        e.preventDefault();
        // Update chart to show daily data
    });
    document.getElementById('showRevenueByWeek').addEventListener('click', function(e) {
        e.preventDefault();
        // Update chart to show weekly data
    });
    document.getElementById('showRevenueByMonth').addEventListener('click', function(e) {
        e.preventDefault();
        // Update chart to show monthly data
    });
});