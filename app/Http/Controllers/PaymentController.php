<?php

namespace App\Http\Controllers;

use App\Services\VNPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required',
            'amount' => 'required|numeric',
            'order_desc' => 'required',
        ]);

        $ipAddr = $request->ip();

        $paymentUrl = $this->vnpayService->createPayment(
            $validated['order_id'],
            $validated['amount'],
            $validated['order_desc'],
            $ipAddr
        );

        return redirect()->away($paymentUrl);
    }

    public function handleReturn(Request $request)
    {
        $response = $this->vnpayService->validateResponse($request->all());

        if ($response['success']) {
            // Xử lý khi thanh toán thành công
            return view('payment.success', $response);
        }

        // Xử lý khi thanh toán thất bại
        return view('payment.fail', $response);
    }
}
