<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;

class BookingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DANH SÁCH BOOKING
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $bookings = Booking::with([
            'tour',
            'trip',
            'group',
            'user'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.bookings.index',compact('bookings'));

    }



    /*
    |--------------------------------------------------------------------------
    | CHI TIẾT BOOKING
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $booking = Booking::with([
            'tour',
            'trip',
            'group',
            'customers',
            'user'
        ])->findOrFail($id);

        return view('admin.bookings.show',compact('booking'));

    }



    /*
    |--------------------------------------------------------------------------
    | CẬP NHẬT TRẠNG THÁI BOOKING
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request,$id)
    {

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status'=>$request->status
        ]);

        return back()->with('success','Cập nhật trạng thái thành công');

    }

}