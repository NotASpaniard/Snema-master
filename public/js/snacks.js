document.addEventListener('DOMContentLoaded', function() {
    // Xử lý tăng/giảm số lượng snack
    document.querySelectorAll('.increase').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.parentNode.querySelector('.quantity');
            input.value = parseInt(input.value) + 1;
            updateSnackTotal();
        });
    });

    document.querySelectorAll('.decrease').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.parentNode.querySelector('.quantity');
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateSnackTotal();
            }
        });
    });


    // Tính tổng tiền snack
    function updateSnackTotal() {
        let total = 0;
        document.querySelectorAll('.snack-item').forEach(item => {
            const price = parseFloat(item.dataset.price);
            const qty = parseInt(item.querySelector('.quantity').value);
            total += price * qty;
        });
        document.getElementById('snack-total').textContent = total.toLocaleString();
    }
});

