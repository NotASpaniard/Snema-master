<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sơ đồ ghế - {{ $room->room_number }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .seat {
            width: 50px;
            height: 50px;
            margin: 4px;
            text-align: center;
            line-height: 50px;
            border-radius: 6px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            user-select: none;
        }

        .seat.inactive {
            background-color: #6c757d !important;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: #ffc107 !important;
            color: black;
        }

        .seat-row {
            display: flex;
            justify-content: center;
            margin-bottom: 8px;
        }

        .screen {
            width: 100%;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>

@php
    $seats = $room->seats->sortBy('id')->values();
    $total_seats = $room->total_seat;
    $seats_per_row = 8;
    $row_labels = range('A', 'Z');
@endphp

<div class="container py-4">
    <h3>Sơ đồ ghế: <strong>{{ $room->name }}</strong></h3>
    <div class="screen text-center fw-bold text-secondary mb-3">MÀN HÌNH</div>

    @for ($i = 0; $i < $total_seats; $i += $seats_per_row)
        <div class="seat-row">
            @for ($j = 0; $j < $seats_per_row && ($i + $j) < $total_seats; $j++)
                @php
                    $seat_index = $i + $j;
                    $seat = $seats[$seat_index] ?? null;
                    $row_label = $row_labels[intdiv($seat_index, $seats_per_row)] ?? '?';
                    $seat_label = $row_label . ($j + 1);
                @endphp

                @if ($seat)
                    <div
                        class="seat {{ $seat->seat_status === 0 ? 'inactive' : '' }}"
                        data-seat-id="{{ $seat->id }}"
                        data-seat-label="{{ $seat_label }}"
                        onclick="toggleSeat(this)"
                    >
                        {{ $seat_label }}
                    </div>
                @else
                    <div class="seat bg-secondary text-white">
                        {{ $seat_label }}
                    </div>
                @endif
            @endfor
        </div>
    @endfor

    <div class="mt-4">
        <button class="btn btn-danger" onclick="submitSelectedSeats()">Đổi trạng thái ghế đã chọn</button>
        <a href="{{ route('admin.rooms') }}" class="btn btn-secondary ms-2">← Quay lại</a>
    </div>

    <div class="mt-3">
        <strong>Ghế đã chọn:</strong>
        <span id="selected-seats-display" class="text-success"></span>
    </div>
</div>

<script>
    let selected_seats = [];

    function toggleSeat(el) {
        const seatId = el.dataset.seatId;
        const seatLabel = el.dataset.seatLabel;

        if (el.classList.contains('selected')) {
            el.classList.remove('selected');
            selected_seats = selected_seats.filter(s => s.id !== seatId);
        } else {
            el.classList.add('selected');
            selected_seats.push({ id: seatId, label: seatLabel });
        }

        updateSelectedDisplay();
    }

    function updateSelectedDisplay() {
        const display = document.getElementById('selected-seats-display');
        display.textContent = selected_seats.map(s => s.label).join(', ');
    }

    function submitSelectedSeats() {
        const ids = selected_seats.map(s => s.id);

        if (ids.length === 0) {
            alert("Bạn chưa chọn ghế nào!");
            return;
        }

        fetch('{{ route("seats.bulkDisable") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ seat_ids: ids })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    data.toggled.forEach(seat => {
                        const el = document.querySelector(`[data-seat-id="${seat.id}"]`);
                        if (!el) return;

                        el.classList.remove('selected');

                        if (seat.new_status == 0) {
                            el.classList.add('inactive');
                            el.style.cursor = 'not-allowed';
                        } else {
                            el.classList.remove('inactive');
                            el.style.cursor = 'pointer';
                        }
                    });

                    selected_seats = [];
                    updateSelectedDisplay();
                    alert("Đã cập nhật trạng thái cho các ghế đã chọn.");
                }
            });

    }
</script>

</body>
</html>
