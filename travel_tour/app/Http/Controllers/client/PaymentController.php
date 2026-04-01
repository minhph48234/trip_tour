<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class PaymentController extends Controller
{

    /*
    =================================
    CHUYỂN SANG CỔNG THANH TOÁN VNPAY
    =================================
    */

    public function vnpay_payment($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpayReturn');
        $vnp_TmnCode = "I2TN3DK9";
        $vnp_HashSecret = "PCLSO1HKWNEEDKEOKFI56Q6HYDGPC7F6";

        $vnp_TxnRef = $booking->booking_code;

        $depositAmount = $booking->total_price * 0.5;

        Payment::firstOrCreate(
            [
                'vnp_txn_ref' => $vnp_TxnRef,
                'booking_id' => $booking->id
            ],
            [
                'method' => 'vnpay',
                'type' => 'deposit',
                'amount' => $depositAmount,
                'status' => 'pending'
            ]
        );

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $depositAmount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toan coc booking " . $booking->booking_code,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);

        $query = "";
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $hashdata = rtrim($hashdata, '&');
        $query = rtrim($query, '&');

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        return redirect($vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash);
    }

    /*
    =================================
    RETURN TỪ VNPAY
    =================================
    */

     public function vnpayReturn(Request $request)
    {
        $txnRef = $request->vnp_TxnRef;

        $payment = Payment::where('vnp_txn_ref', $txnRef)->first();

        if (!$payment) {
            return redirect('/')->with('error', 'Không tìm thấy payment');
        }

        $booking = $payment->booking;

        if (!$booking) {
            return redirect('/')->with('error', 'Booking không tồn tại');
        }

        $isSuccess = $request->vnp_ResponseCode == "00";

        if ($isSuccess) {

            // ✅ UPDATE PAYMENT
            $payment->update([
                'status' => 'paid',
                'transaction_code' => $request->vnp_TransactionNo ?? null,
                'paid_at' => now()
            ]);

            // ✅ PHÂN LOẠI
            $this->updatePaymentType($payment);

            // ✅ QUAN TRỌNG: CỘNG TIỀN CHỈ KHI SUCCESS
            $booking->paid_amount += $payment->amount;

            $booking->save();

            // ✅ UPDATE STATUS CHUẨN
            $this->updateBookingStatus($booking);

            return redirect()
                ->route('payment.history')
                ->with('success', 'Thanh toán thành công');
        }

        // ❌ FAIL → KHÔNG ĐƯỢC ĐỘNG VÀO BOOKING
        $payment->update([
            'status' => 'failed'
        ]);

        return redirect()
            ->route('payment.history')
            ->with('error', 'Thanh toán thất bại');
    }

    private function updatePaymentType($payment)
    {
        if (str_contains($payment->vnp_txn_ref, '_FINAL_')) {
            $payment->type = 'final';
        } else {
            $payment->type = 'deposit';
        }

        $payment->save();
    }

    private function updateBookingStatus($booking)
    {
        $totalPaid = $booking->payments()
            ->where('status', 'paid')
            ->sum('amount');

        $deposit = $booking->deposit_amount;
        $total = $booking->total_price;

        if ($totalPaid >= $total) {
            $booking->status = 'paid';
        } elseif ($totalPaid >= $deposit) {
            $booking->status = 'deposit_paid';
        } else {
            $booking->status = 'pending';
        }

        $booking->save();
    }

    
 /*
    =================================
    LỊCH SỬ THANH TOÁN
    =================================
    */
    public function history()
    {
        $payments = Payment::with('booking')
            ->whereHas('booking', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('id', 'desc') // ✅ FIX lỗi created_at
            ->paginate(10);

        return view('clients.payment.history', compact('payments'));
    }

    // CHI TIẾT THANH TOÁN
    public function show($id)
    {
        $payment = Payment::with('booking')
            ->whereHas('booking', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($id);

        return view('clients.payment.show', compact('payment'));
    }

    // thanh toán phần con còn lại
    public function vnpayFinal($bookingId)
{
    $booking = Booking::findOrFail($bookingId);

    // số tiền còn lại
    $remaining = $booking->total_price - $booking->paid_amount;

    if ($remaining <= 0) {
        return redirect()->back()->with('error', 'Đã thanh toán đủ');
    }

    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = route('payment.vnpayReturn');
    $vnp_TmnCode = "I2TN3DK9";
    $vnp_HashSecret = "PCLSO1HKWNEEDKEOKFI56Q6HYDGPC7F6";

    // ⚠️ quan trọng: txnRef khác để tránh trùng
    $vnp_TxnRef = $booking->booking_code . '_FINAL_' . time();

    // tạo payment
    Payment::create([
        'booking_id' => $booking->id,
        'method' => 'vnpay',
        'type' => 'final',
        'amount' => $remaining,
        'status' => 'pending',
        'vnp_txn_ref' => $vnp_TxnRef
    ]);

    $vnp_Amount = $remaining * 100;

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => request()->ip(),
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => "Thanh toan full booking " . $booking->booking_code,
        "vnp_OrderType" => "billpayment",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    ];

    ksort($inputData);

    $query = "";
    $hashdata = "";

    foreach ($inputData as $key => $value) {
        $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $hashdata = rtrim($hashdata, '&');
    $query = rtrim($query, '&');

    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

    $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

    return redirect($vnp_Url);
}

}