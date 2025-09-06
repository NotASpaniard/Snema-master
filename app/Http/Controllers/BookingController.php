<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\BookingDetail;
use App\Models\BookingSnack;
use App\Models\Movie;
use App\Models\PaymentOption;
use App\Models\Promotion;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with([
            'customers:id,name,email,phone_number',
            'admins:id,name,email',
            'showtime.movie:id,title,duration',
            'showtime.room.cinema:id,name',
            'payment_options:id,option',
            'promotion:id,promotion_type',
            'booking_snacks.snack:id,name,price',
            'booking_details.seat:id,seat_code,seat_type'
        ])
            ->whereHas('customers')
            ->whereHas('showtime.movie')
            ->whereHas('booking_details.seat')
            ->get();

        return view('Admin.orders', compact('bookings'));
    }

    public function history() {
        $customer_id = session('customer_id');

        $bookings = Booking::with([
            'customers:id,name,email,phone_number',
            'admins:id,name,email',
            'showtime.movie:id,title,duration',
            'showtime.room.cinema:id,name',
            'payment_options:id,option',
            'promotion:id,promotion_type',
            'booking_snacks.snack:id,name,price',
            'booking_details.seat:id,seat_code,seat_type'
        ])
            ->whereHas('customers')
            ->whereHas('showtime.movie')
            ->whereHas('booking_details.seat')
            ->where('customer_id', $customer_id)
            ->get();

        return view('Customer.history', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $today = Carbon::now();
        $is_weekend = $today->isSaturday() || $today->isSunday();

        $promotion = Promotion::where('id', 1)->first(); // hoặc where('id', 1)->first()
        if ($is_weekend && $promotion) {
            $promotions = $promotion;
            $discount_percent = $promotion->promotion_type; // ví dụ: 25 hoặc 50
        }

        $payment_options = [
            1 => 'Thanh toán VNPay',
        ];

        $showtime = Showtime::with('room')->findOrFail($request->showtime_id);
        $movie = Movie::findOrFail($request->movie_id);
        $seats = Seat::where('room_id', $showtime->room_id)->get();

        // Load danh sách snack từ bảng `snacks` (không phải booking_snacks)
        $snacks = Snack::all();

        // Danh sách ghế đã được đặt
        $booked_seat_ids = DB::table('booking_details')
            ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->where('bookings.showtime_id', $showtime->id)
            ->pluck('seat_id')
            ->toArray();

        return view('Customer.booking', compact(
            'movie',
            'showtime',
            'seats',
            'booked_seat_ids',
            'payment_options',
            'promotion',
            'snacks' // truyền vào view
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $request->validate([
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'movie_id' => 'required|exists:movies,id',
            'room_id' => 'required|exists:rooms,id',
            'payment_id' => 'required|exists:payment_options,id',
            'promotion_id' => 'nullable|exists:promotions,id',
            'snack_qty' => 'nullable|array',
        ]);

        $customer_id = session('customer_id');
        if (!$customer_id) {
            return redirect()->route('customer.login')->with('error', 'Vui lòng đăng nhập để đặt vé.');
        }

        // 1. Tính tổng tiền ghế
        $total_price = 0;
        foreach ($request->seat_ids as $seat_id) {
            $seat = Seat::find($seat_id);
            if (!$seat) continue;

            $total_price += $seat->seat_price;
        }

        // 2. Xử lý đồ ăn
        $snack_total = 0;
        $snack_items = [];
        $booking_snacks_id = null;

        if ($request->snack_qty) {
            foreach ($request->snack_qty as $snack_id => $quantity) {
                $quantity = (int)$quantity;
                if ($quantity > 0) {
                    $snack = Snack::find($snack_id);
                    if ($snack) {
                        $item_total = $snack->price * $quantity;
                        $snack_total += $item_total;
                        $snack_items[] = [
                            'snack_id' => $snack_id,
                            'quantity' => $quantity,
                            'price' => $snack->price,
                            'total_price' => $item_total
                        ];
                    }
                }
            }

            // 3. Tạo booking_snacks nếu có đồ ăn
            if (!empty($snack_items)) {
                $booking_snack = BookingSnack::create([
                    'snack_id' => $snack_items[0]['snack_id'], // Lưu snack đầu tiên
                    'quantity' => $snack_items[0]['quantity'],
                    'price' => $snack_items[0]['price'],
                    'total_price' => $snack_total
                ]);
                $booking_snacks_id = $booking_snack->id;

                // Lưu các snack còn lại vào JSON (nếu có nhiều hơn 1 snack)
                if (count($snack_items) > 1) {
                    $additional_snacks = array_slice($snack_items, 1);
                    $booking_snack->additional_snacks = json_encode($additional_snacks);
                    $booking_snack->save();
                }
            }
        }

        // 4. Tính giảm giá nếu có
        $discount_price = 0;
        if ($request->promotion_id) {
            $promotion = Promotion::find($request->promotion_id);
            if ($promotion) {
                $discount_price = ($total_price + $snack_total) * ($promotion->promotion_type / 100);
            }
        }

        $final_price = ($total_price + $snack_total) - $discount_price;

        // 5. Tạo booking
        $booking = Booking::create([
            'showtime_id' => $request->showtime_id,
            'movie_id' => $request->movie_id,
            'room_id' => $request->room_id,
            'customer_id' => $customer_id,
            'admin_id' => $request->admin_id,
            'payment_id' => $request->payment_id,
            'promotion_id' => $request->promotion_id,
            'booking_snacks_id' => $booking_snacks_id,
            'total_price' => $total_price + $snack_total,
            'discount_price' => $discount_price,
            'final_price' => $final_price,
            'status' => '1',
        ]);

        // 6. Tạo booking_details cho mỗi ghế
        foreach ($request->seat_ids as $seat_id) {
            BookingDetail::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat_id,
                'booking_time' => Carbon::now(),
                'price' => $final_price,
            ]);
        }

        // Đổi trạng thái ghế thành đã bị khóa (seat_status = 0)
        $seat = Seat::find($seat_id);
        if ($seat) {
            $seat->seat_status = 0;
            $seat->save();
        }

        return redirect()->route('customers.index')->with('success', 'Đặt vé thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::with([
            'showtime.movie',
            'showtime.room.cinema',
            'booking_details.seat',
            'booking_details'
            ])->findOrFail($id);
        return view('Customer.history', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::with('booking_details')->findOrFail($id);

        // Khôi phục lại trạng thái seat
        foreach ($booking->details as $detail) {
            $seat = Seat::find($detail->seat_id);
            if ($seat) {
                $seat->seat_status = 1; // khôi phục lại ghế
                $seat->save();
            }
        }

        // Xoá chi tiết booking
        BookingDetail::where('booking_id', $booking->id)->delete();

        // Xoá booking
        $booking->delete();

        return redirect()->back()->with('success', 'Huỷ vé thành công!');
    }
}
