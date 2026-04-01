<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\TourGuide;
use App\Models\Booking;
use App\Models\BookingCustomer;
use App\Models\Attendance;


class GroupController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DANH SÁCH ĐOÀN
    |--------------------------------------------------------------------------
    */

   public function index(Request $request)
    {
        $query = Group::with([
            'trip.tour',
            'guide'
        ]);

        // ================= SEARCH TOUR NAME =================
        if ($request->filled('keyword')) {
            $query->whereHas('trip.tour', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        // ================= SEARCH DATE =================
        if ($request->filled('start_date')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->whereDate('start_date', $request->start_date);
            });
        }

        $groups = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.groups.index', compact('groups'));
    }



    /*
    |--------------------------------------------------------------------------
    | CHI TIẾT ĐOÀN
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $group = Group::with([
            'trip.tour',
            'guide',
            'bookings.customers'
        ])->findOrFail($id);

        $guides = TourGuide::all();

        return view('admin.groups.show',compact('group','guides'));

    }



    /*
    |--------------------------------------------------------------------------
    | PHÂN CÔNG HƯỚNG DẪN VIÊN
    |--------------------------------------------------------------------------
    */

   public function assignGuide(Request $request, $id)
{
    $request->validate([
        'guide_id' => 'required|exists:tour_guides,id'
    ]);

    $group = Group::with('trip')->findOrFail($id);

    $guide = TourGuide::findOrFail($request->guide_id);

    $tripStart = $group->trip->start_date;
    $tripEnd   = $group->trip->end_date;

    /*
    |--------------------------------------------------
    | 1. CHECK STATUS GUIDE
    |--------------------------------------------------
    */

    if ($guide->status == 'inactive') {
        return back()->with('error', 'Hướng dẫn viên đã bị khóa');
    }

    if ($guide->status == 'busy') {
        return back()->with('error', 'Hướng dẫn viên đang bận');
    }

    /*
    |--------------------------------------------------
    | 2. CHECK TRÙNG LỊCH (NÂNG CAO - REAL PROJECT)
    |--------------------------------------------------
    */

    $exists = Group::where('guide_id', $guide->id)
        ->whereHas('trip', function ($q) use ($tripStart, $tripEnd) {
            $q->where(function ($query) use ($tripStart, $tripEnd) {

                // trùng khoảng thời gian
                $query->whereBetween('start_date', [$tripStart, $tripEnd])
                      ->orWhereBetween('end_date', [$tripStart, $tripEnd]);
            });
        })
        ->exists();

    if ($exists) {
        return back()->with('error', 'Hướng dẫn viên bị trùng lịch');
    }

    /*
    |--------------------------------------------------
    | 3. ASSIGN GUIDE
    |--------------------------------------------------
    */

    $group->update([
        'guide_id' => $guide->id
    ]);

    /*
    |--------------------------------------------------
    | 4. UPDATE STATUS GUIDE -> BUSY
    |--------------------------------------------------
    */

    $guide->update([
        'status' => 'busy'
    ]);

    return back()->with('success', 'Phân công thành công');
}



}