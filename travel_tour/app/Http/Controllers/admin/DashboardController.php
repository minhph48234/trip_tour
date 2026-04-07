<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        =========================
        THỐNG KÊ TỔNG QUAN
        =========================
        */

        $tourCount = Tour::count();
        $bookingCount = Booking::count();
        $userCount = User::count();

        // tổng doanh thu
        $revenue = Payment::where('status', 'paid')->sum('amount');

        /*
        =========================
        XÁC ĐỊNH CỘT NGÀY
        =========================
        */

        $dateColumn = null;

        if (Schema::hasColumn('payments', 'created_at')) {
            $dateColumn = 'created_at';
        } elseif (Schema::hasColumn('payments', 'payment_date')) {
            $dateColumn = 'payment_date';
        }
        $today = Carbon::today();
        /*
        =========================
        DOANH THU (FIX CHUẨN)
        =========================
        */

        if ($dateColumn) {

            // 🔥 FIX LỖI DOANH THU HÔM NAY
            $revenueToday = Payment::where('status', 'paid')
                ->whereBetween($dateColumn, [
                    $today->startOfDay(),
                    $today->copy()->endOfDay()
                ])
                ->sum('amount');

            $revenueMonth = Payment::where('status', 'paid')
                ->whereMonth($dateColumn, $today->month)
                ->whereYear($dateColumn, $today->year)
                ->sum('amount');

            $revenueYear = Payment::where('status', 'paid')
                ->whereYear($dateColumn, $today->year)
                ->sum('amount');
        } else {
            // fallback
            $revenueToday = 0;
            $revenueMonth = $revenue;
            $revenueYear = $revenue;
        }

        /*
        =========================
        BOOKING CHƯA XỬ LÝ
        =========================
        */

        // ⚠️ Đơn chưa xử lý (pending + chưa thanh toán)
        $pendingBookings = Booking::whereIn('status', ['pending', 'unpaid'])
            ->count();

        /*
        =========================
        CHƯA THANH TOÁN FULL (CHUẨN NHẤT)
        =========================
        */

        $pendingFullBookings = Booking::withSum(
            ['payments as total_paid' => function ($q) {
                $q->where('status', 'paid');
            }],
            'amount'
        )
            ->get()
            ->filter(function ($booking) {
                return ($booking->total_paid ?? 0) < $booking->total_price;
            })
            ->count();

        /*
        =========================
        TRIP
        =========================
        */

        // sắp khởi hành (1–3 ngày)
        $upcomingTrips = Trip::whereBetween('start_date', [
            now(),
            now()->addDays(3)
        ])->count();

        // sắp full (>=80%)
        $almostFullTrips = Trip::whereRaw('current_people >= max_people * 0.8')
            ->count();

        /*
        =========================
        TOP TOUR
        =========================
        */

        // nhiều booking nhất
        $topToursByBooking = Tour::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        // doanh thu cao nhất
        $topToursByRevenue = Tour::select('tours.*')
            ->selectSub(function ($query) {
                $query->from('payments')
                    ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
                    ->join('trips', 'bookings.trip_id', '=', 'trips.id')
                    ->whereColumn('trips.tour_id', 'tours.id')
                    ->where('payments.status', 'paid')
                    ->selectRaw('SUM(payments.amount)');
            }, 'total_revenue')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        /*
        =========================
        RETURN VIEW
        =========================
        */

        return view('admin.dashboard', compact(
            'tourCount',
            'bookingCount',
            'userCount',
            'revenue',

            'revenueToday',
            'revenueMonth',
            'revenueYear',

            'pendingBookings',
            'pendingFullBookings',

            'upcomingTrips',
            'almostFullTrips',

            'topToursByBooking',
            'topToursByRevenue'
        ));
    }
}
