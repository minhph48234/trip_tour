<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /*
    =================================
    DANH SÁCH THANH TOÁN
    =================================
    */
    public function index()
    {
        $payments = Payment::with([
            'booking.user',
            'booking.tour',
            'booking.trip'
        ])
        ->orderByDesc('id')
        ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    /*
    =================================
    CHI TIẾT THANH TOÁN
    =================================
    */
    public function show($id)
    {
        $payment = Payment::with([
            'booking.user',
            'booking.tour',
            'booking.trip',
            'booking.payments'
        ])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    /*
    =================================
    XÁC NHẬN THANH TOÁN (ADMIN)
    =================================
    */
    public function confirm($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);

        // ❌ chưa thanh toán thì không cho xác nhận
        if ($payment->status !== 'paid') {
            return back()->with('error', 'Thanh toán chưa hoàn tất!');
        }

        // ❌ đã xác nhận rồi thì không xác nhận lại
        if ($payment->admin_confirm_status === 'confirmed') {
            return back()->with('error', 'Thanh toán này đã được xác nhận!');
        }

        // ✅ cập nhật trạng thái admin
        $payment->admin_confirm_status = 'confirmed';
        $payment->save();

        // =====================================
        // 🔥 CẬP NHẬT BOOKING THEO TIỀN
        // =====================================
        $booking = $payment->booking;

        $totalPaid = $booking->payments()
            ->where('status', 'paid')
            ->sum('amount');

        // cập nhật số tiền đã thanh toán
        $booking->paid_amount = $totalPaid;

        if ($totalPaid >= $booking->total_price) {
            $booking->status = 'paid';
        } elseif ($totalPaid >= $booking->deposit_amount) {
            $booking->status = 'deposit_paid';
        } else {
            $booking->status = 'pending';
        }

        $booking->save();

        return back()->with('success', 'Đã xác nhận thanh toán thành công!');
    }
}