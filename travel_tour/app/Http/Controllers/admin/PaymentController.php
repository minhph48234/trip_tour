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
    public function index(Request $request)
    {
        $query = Payment::with(['booking.tour']);
    
        // 🔍 SEARCH (customer + tour)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
    
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('booking', function ($q2) use ($keyword) {
                    $q2->where('customer_name', 'like', "%$keyword%");
                })
                ->orWhereHas('booking.tour', function ($q2) use ($keyword) {
                    $q2->where('name', 'like', "%$keyword%");
                });
            });
        }
    
        // 🎯 FILTER STATUS (ENUM chuẩn DB)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // 💳 FILTER METHOD (ENUM)
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }
    
        // 🚀 PAGINATE + giữ query
        $payments = $query
    ->orderByDesc('paid_at')
    ->paginate(10)
    ->withQueryString();
    
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

        // ❌ đã xác nhận full rồi thì chặn
        if ($payment->admin_confirm_status === 'confirmed') {
            return back()->with('error', 'Thanh toán này đã được xác nhận đủ!');
        }

        // =========================================
        // 🔥 PHÂN BIỆT CỌC VS THANH TOÁN HẾT
        // =========================================
        if ($payment->type === 'deposit') {
            $payment->admin_confirm_status = 'deposit_confirmed';
        } else {
            $payment->admin_confirm_status = 'confirmed';
        }

        $payment->confirmed_at = now();
        $payment->save();

        // =========================================
        // 🔥 UPDATE BOOKING
        // =========================================
        $booking = $payment->booking;

        $totalPaid = $booking->payments()
            ->where('status', 'paid')
            ->whereIn('admin_confirm_status', ['deposit_confirmed','confirmed'])
            ->sum('amount');

        $booking->paid_amount = $totalPaid;

        if ($totalPaid >= $booking->total_price) {
            $booking->status = 'paid';
        } elseif ($totalPaid >= $booking->deposit_amount) {
            $booking->status = 'deposit_paid';
        } else {
            $booking->status = 'pending';
        }

        $booking->save();

        return back()->with('success', 'Xác nhận thanh toán thành công!');
    }
}