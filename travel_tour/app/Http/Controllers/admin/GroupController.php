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

        return view('admin.groups.show', compact('group', 'guides'));
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

        /*
        |--------------------------------------------------
        | 0. CHECK ĐỦ KHÁCH CHƯA (🔥 MỚI)
        |--------------------------------------------------
        */
        if ($group->current_people < $group->min_people) {
            return back()->with('error', 
                'Đoàn chưa đủ số lượng tối thiểu (' 
                . $group->min_people . ' khách). Không thể phân công hướng dẫn viên!'
            );
        }

        /*
        |--------------------------------------------------
        | 1. CHECK GUIDE STATUS
        |--------------------------------------------------
        */
        if ($guide->status == 'inactive') {
            return back()->with('error', 'Hướng dẫn viên đã bị khóa');
        }

        $tripStart = $group->trip->start_date;
        $tripEnd   = $group->trip->end_date;

        /*
        |--------------------------------------------------
        | 2. CHECK TRÙNG LỊCH
        |--------------------------------------------------
        */
        $isOverlap = Group::where('guide_id', $guide->id)
            ->where('id', '!=', $group->id)
            ->whereHas('trip', function ($q) use ($tripStart, $tripEnd) {
                $q->where(function ($query) use ($tripStart, $tripEnd) {
                    $query->where('start_date', '<=', $tripEnd)
                          ->where('end_date', '>=', $tripStart);
                });
            })
            ->exists();

        if ($isOverlap) {
            return back()->with('error', 'Hướng dẫn viên bị trùng lịch / trùng ngày');
        }

        /*
        |--------------------------------------------------
        | 3. ASSIGN GUIDE
        |--------------------------------------------------
        */
        $group->update([
            'guide_id' => $guide->id
        ]);

        return back()->with('success', 'Phân công thành công');
    }
}