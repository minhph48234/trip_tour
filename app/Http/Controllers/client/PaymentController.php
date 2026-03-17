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
        $vnp_OrderInfo = "Thanh toan booking " . $booking->booking_code;
        $vnp_Amount = $booking->total_price * 100;
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
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

    /*
    =================================
    RETURN TỪ VNPAY
    =================================
    */

    public function vnpayReturn(Request $request)
    {

        $bookingCode = $request->vnp_TxnRef;

        $booking = Booking::where('booking_code', $bookingCode)->first();

        if (!$booking) {
            return redirect('/')
                ->with('error', 'Booking không tồn tại');
        }

        $isSuccess = $request->vnp_ResponseCode == "00";

        Payment::create([
            'booking_id' => $booking->id,
            'method' => 'vnpay',
            'amount' => $request->vnp_Amount / 100,
            'status' => $isSuccess ? 'paid' : 'failed',
            'vnp_txn_ref' => $request->vnp_TxnRef,
            'vnp_response_code' => $request->vnp_ResponseCode,
            'transaction_code' => $request->vnp_TransactionNo ?? null,
            'paid_at' => $isSuccess ? now() : null
        ]);

        if ($isSuccess) {

            $booking->update([
                'status' => 'confirmed'
            ]);

            return redirect()
                ->route('booking.show', $booking->id)
                ->with('success', 'Thanh toán thành công');
        }

        $booking->update([
            'status' => 'canceled'
        ]);

        return redirect()
            ->route('booking.show', $booking->id)
            ->with('error', 'Thanh toán thất bại');
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

}