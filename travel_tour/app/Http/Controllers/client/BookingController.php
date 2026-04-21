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
            'customers' => 'required|array|min:1',
            'customers.*.name' => 'required|string|max:255',
            'customers.*.phone' => 'required|string|max:20',
            'customers.*.birthdate' => 'required|date',
            'customers.*.type' => 'required|in:adult,child',
        ]);

        DB::beginTransaction();

        try {

            $trip = Trip::with('tour')->findOrFail($request->trip_id);

            /*
            =================================
            CHẶN ĐẶT TOUR
            =================================
            */
            $today = Carbon::today();
            $startDate = Carbon::parse($trip->start_date);
            $daysLeft = $today->diffInDays($startDate, false);

            if (
                $trip->status !== 'open' ||
                $daysLeft <= 2 ||
                $startDate->isPast()
            ) {
                return back()
                    ->with('error', 'Tour đã đóng / sắp khởi hành / quá ngày')
                    ->withInput();
            }

            /*
            =================================
            SỐ LƯỢNG KHÁCH
            =================================
            */
            $quantity = count($request->customers);

            /*
            =================================
            🔥 CHECK FULL TRIP → TẠO TRIP MỚI
            =================================
            */
            if (($trip->current_people + $quantity) > $trip->max_people) {

                $newStart = Carbon::parse($trip->start_date)->addDays(7);
                $newEnd   = Carbon::parse($trip->end_date)->addDays(7);

                // tránh tạo trùng trip
                $newTrip = Trip::where('tour_id', $trip->tour_id)
                    ->whereDate('start_date', $newStart)
                    ->first();

                if (!$newTrip) {
                    $newTrip = Trip::create([
                        'tour_id' => $trip->tour_id,
                        'start_date' => $newStart,
                        'end_date' => $newEnd,
                        'max_people' => $trip->max_people,
                        'current_people' => 0,
                        'status' => 'open'
                    ]);
                }

                $trip = $newTrip;
            }

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
            TÍNH GIÁ CHUẨN (KHÔNG TIN FRONTEND)
            =================================
            */
            $totalPrice = 0;

            foreach ($request->customers as $c) {
                if ($c['type'] === 'child') {
                    $totalPrice += $trip->tour->child_price;
                } else {
                    $totalPrice += $trip->tour->price;
                }
            }

            $depositAmount = $totalPrice * 0.5;

            /*
            =================================
            TẠO BOOKING
            =================================
            */
            $booking = Booking::create([
                'booking_code' => 'BK' . date('YmdHis'),
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

            /*
            =================================
            LƯU DANH SÁCH KHÁCH
            =================================
            */
            foreach ($request->customers as $customer) {
                BookingCustomer::create([
                    'booking_id' => $booking->id,
                    'name' => $customer['name'],
                    'phone' => $customer['phone'],
                    'gender' => $customer['gender'] ?? null,
                    'birthdate' => $customer['birthdate'],
                    'type' => $customer['type']
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

            return redirect()
                ->route('payment.vnpay', $booking->id)
                ->with('success', 'Đặt tour thành công');

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