<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingSnack;
use App\Models\Promotion;
use App\Models\Seat;
use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
//        $amount = (int) $request->input('amount');
//        if ($amount <= 0) {
//            return redirect()->back()->with('error', 'Tổng tiền không hợp lệ.');
//        }

        session([
            'booking_data' => [
                'movie_id' => $request->movie_id,
                'room_id' => $request->room_id,
                'showtime_id' => $request->showtime_id,
                'customer_id' => session('customer_id'),
                'payment_id' => $request->payment_id,
                'promotion_id' => $request->promotion_id,
                'seat_ids' => $request->seat_ids ?? [],
                'snack_qty' => $request->snack_qty ?? [],
                'final_price' => $request->amount,
                'admin_id' =>$request->admin_id,
            ]
        ]);

        // Thiết lập thông tin thanh toán VNPAY
        $vnp_TmnCode = 'TL5UPZY3';
        $vnp_HashSecret = 'FNMD0HT4O4NQI00TSNQDK9DRRK2GKKQ2';
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_Returnurl = 'http://localhost/Snema/public/vnpay-return';

        $order_id = uniqid();
        $vnp_Amount = $request->amount * 100;
        $vnp_TxnRef = $order_id;
        $vnp_OrderInfo = 'Thanh toán vé xem phim';
        $vnp_OrderType = 'billpayment';
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdata = http_build_query($inputData);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        $query = http_build_query($inputData);
        $vnp_Url = $vnp_Url . '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;

//        dd([
//            'URL gửi đến VNPAY' => $vnp_Url,
//            'Hashdata dùng để ký' => $hashdata,
//            'Chữ ký đã tạo' => $vnpSecureHash,
//        ]);

//        Log::info("===== VNPay Log =====");
//        Log::info("URL gửi đến VNPAY: " . $vnp_Url);
//        Log::info("Hashdata dùng để ký: " . $hashdata);
//        Log::info("Chữ ký đã tạo: " . $vnpSecureHash);

        return redirect($vnp_Url);
    }


    public function vnpayReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == '00') {
            $data = session('booking_data');

            if (!$data) {
                return redirect()->route('customers.index')->with('error', 'Không tìm thấy dữ liệu đặt vé.');
            }

            $customer_id = $data['customer_id'];
            $seat_ids = $data['seat_ids'];
            $snack_qty = $data['snack_qty'] ?? [];
            $total_price = 0;
            $snack_total = 0;
            $booking_snacks_id = null;
            $snack_items = [];

            // 1. Tính tiền ghế
            foreach ($seat_ids as $seat_id) {
                $seat = Seat::find($seat_id);
                if (!$seat) continue;;
                $total_price += $seat->seat_price;
            }

            // 2. Tính tiền đồ ăn
            foreach ($snack_qty as $snack_id => $quantity) {
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

            if (!empty($snack_items)) {
                $booking_snack = BookingSnack::create([
                    'snack_id' => $snack_items[0]['snack_id'],
                    'quantity' => $snack_items[0]['quantity'],
                    'price' => $snack_items[0]['price'],
                    'total_price' => $snack_total
                ]);
                $booking_snacks_id = $booking_snack->id;

                if (count($snack_items) > 1) {
                    $booking_snack->additional_snacks = json_encode(array_slice($snack_items, 1));
                    $booking_snack->save();
                }
            }

            // 3. Tính giảm giá
            $discount_price = 0;
            if ($data['promotion_id']) {
                $promotion = Promotion::find($data['promotion_id']);
                if ($promotion) {
                    $discount_price = ($total_price + $snack_total) * ($promotion->promotion_type / 100);
                }
            }

            $final_price = ($total_price + $snack_total) - $discount_price;

            // 4. Tạo booking
            $booking = Booking::create([
                'showtime_id' => $data['showtime_id'],
                'movie_id' => $data['movie_id'],
                'room_id' => $data['room_id'],
                'customer_id' => $customer_id,
                'admin_id' => $data['admin_id'] ?? null,
                'payment_id' => $data['payment_id'],
                'promotion_id' => $data['promotion_id'],
                'booking_snacks_id' => $booking_snacks_id,
                'total_price' => $total_price + $snack_total,
                'discount_price' => $discount_price,
                'final_price' => $final_price,
                'status' => '1',
            ]);

            // 5. Ghi chi tiết ghế
            foreach ($seat_ids as $seat_id) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat_id,
                    'booking_time' => Carbon::now(),
                    'price' => Seat::find($seat_id)?->seat_price ?? 0, // lưu đúng giá
                ]);
            }

            // 6. Xoá session và redirect
            session()->forget('booking_data');

            return redirect()->route('customers.index')->with('success', 'Thanh toán và đặt vé thành công!');
        }

        return redirect()->route('customers.index')->with('error', 'Thanh toán thất bại hoặc bị huỷ.');
    }
}

