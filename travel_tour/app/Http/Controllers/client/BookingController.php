<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Trip;
use App\Models\Booking;
use App\Models\BookingCustomer;
use App\Models\Group;

class BookingController extends Controller
{

    /*
    ===============================
    FORM ĐẶT TOUR
    ===============================
    */
    public function create(Request $request, $trip = null)
    {
        if ($request->trip) {
            $trip = $request->trip;
        }

        $trip = Trip::findOrFail($trip);

        return view('clients.booking.create', compact('trip'));
    }

    /*
    ===============================
    LƯU BOOKING + AUTO GHÉP ĐOÀN
    ===============================
    */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'total_people' => 'required|integer|min:1',
            'customers' => 'required|array',
            'customers.*.name' => 'required|string|max:255',
            'customers.*.phone' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {

            $trip = Trip::with('tour')->findOrFail($request->trip_id);

            /*
            =================================
            🔥 CHẶN ĐẶT TOUR (QUAN TRỌNG)
            =================================
            */

            $today = Carbon::today();
            $startDate = Carbon::parse($trip->start_date);

            $daysLeft = $today->diffInDays($startDate, false);

            // ❌ Chặn toàn bộ case lỗi
            if (
                $trip->status !== 'open' ||
                $daysLeft <= 2 ||
                $startDate->isPast()
            ) {
                return back()
                    ->with('error', 'Tour đã đóng / đã quá ngày / hoặc sắp khởi hành (≤ 2 ngày). Không thể đặt.')
                    ->withInput();
            }

            $quantity = $request->total_people;

            /*
            =================================
            AUTO GHÉP ĐOÀN
            =================================
            */

            $group = Group::where('trip_id', $trip->id)
                ->whereIn('status', [
                    Group::STATUS_PENDING,
                    Group::STATUS_CONFIRMED
                ])
                ->whereRaw('(max_people - current_people) >= ?', [$quantity])
                ->first();

            if (!$group) {
                $group = Group::create([
                    'trip_id' => $trip->id,
                    'type' => Group::TYPE_GROUP,
                    'min_people' => 5,
                    'max_people' => $trip->max_people,
                    'current_people' => 0,
                    'status' => Group::STATUS_PENDING,
                    'progress' => Group::PROGRESS_PENDING,
                    'note' => 'Auto created group'
                ]);
            }

            /*
            =================================
            TẠO BOOKING
            =================================
            */

            $bookingCode = 'BK' . date('YmdHis');

            $totalPrice = $trip->tour->price * $quantity;
            $depositAmount = $totalPrice * 0.5;

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => auth()->id(),
                'tour_id' => $trip->tour_id,
                'trip_id' => $trip->id,
                'group_id' => $group->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'deposit_amount' => $depositAmount,
                'paid_amount' => 0,
                'status' => 'pending'
            ]);

            foreach ($request->customers as $customer) {
                BookingCustomer::create([
                    'booking_id' => $booking->id,
                    'name' => $customer['name'],
                    'phone' => $customer['phone'],
                    'gender' => $customer['gender'] ?? null,
                    'birthdate' => $customer['birthdate'] ?? null,
                    'type' => $customer['type'] ?? 'adult'
                ]);
            }

            /*
            =================================
            UPDATE GROUP
            =================================
            */

            $group->increment('current_people', $quantity);
            $group->refresh();
            $group->updateStatus();

            /*
            =================================
            UPDATE TRIP
            =================================
            */
            $trip->increment('current_people', $quantity);

            DB::commit();

            return redirect()->route('payment.vnpay', $booking->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /*
    ===============================
    LỊCH SỬ BOOKING
    ===============================
    */
    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['trip.tour','group','payments'])
            ->latest()
            ->paginate(10);

        foreach ($bookings as $booking) {
            $this->updateBookingStatus($booking);
        }

        return view('clients.booking.history', compact('bookings'));
    }

    /*
    ===============================
    CHI TIẾT BOOKING
    ===============================
    */
    public function show($id)
    {
        $booking = Booking::with([
            'trip.tour',
            'group',
            'customers',
            'payments'
        ])
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        $this->updateBookingStatus($booking);

        $payments = $booking->payments;

        return view('clients.booking.show', compact('booking', 'payments'));
    }

    private function updateBookingStatus($booking)
    {
        $paid = $booking->paid_amount ?? 0;
        $deposit = $booking->deposit_amount ?? 0;
        $total = $booking->total_price ?? 0;

        if ($paid >= $total) {
            $booking->status = 'paid';
        } elseif ($paid >= $deposit) {
            $booking->status = 'deposit_paid';
        } else {
            $booking->status = 'pending';
        }

        $booking->save();
    }
}