<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 📌 Danh sách điểm danh
    public function index()
    {
        $attendances = Attendance::with([
            'trip',
            'group',
            'guide'
        ])
        ->latest()
        ->paginate(10);

        return view('admin.attendances.index', compact('attendances'));
    }

    // 📌 Chi tiết điểm danh
    public function show($id)
    {
        $attendance = Attendance::with([
            'trip',
            'group',
            'guide',
            'details.customer'
        ])->findOrFail($id);

        // thống kê
        $total = $attendance->details->count();
        $present = $attendance->details->where('status', 'present')->count();
        $absent = $attendance->details->where('status', 'absent')->count();
        $late = $attendance->details->where('status', 'late')->count();

        return view('admin.attendances.show', compact(
            'attendance',
            'total',
            'present',
            'absent',
            'late'
        ));
    }
}