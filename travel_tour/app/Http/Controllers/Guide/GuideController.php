<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingCustomer;
use Illuminate\Http\Request;
use App\Models\Attendance; 
use App\Models\AttendanceDetail;

class GuideController extends Controller
{
    /*
    =========================
    DASHBOARD
    =========================
    */
    public function dashboard()
{
    $guideId = auth()->user()->guide->id;

    // tất cả group
    $groups = Group::with(['trip.tour'])
        ->where('guide_id', $guideId)
        ->get();

    // tổng tour
    $totalTours = $groups->count();

    // tổng khách
    $totalCustomers = Booking::whereHas('group', function($q) use ($guideId){
        $q->where('guide_id', $guideId);
    })->sum('quantity');

    // tour trong tuần
    $weeklyTours = Group::where('guide_id', $guideId)
        ->whereHas('trip', function($q){
            $q->whereBetween('start_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        })->count();

    // tour trong tháng
    $monthlyTours = Group::where('guide_id', $guideId)
        ->whereHas('trip', function($q){
            $q->whereMonth('start_date', now()->month)
              ->whereYear('start_date', now()->year);
        })->count();

    // danh sách tour được phân công
    $assignedTours = Group::with(['trip.tour'])
        ->where('guide_id', $guideId)
        ->orderByDesc('id')
        ->limit(5)
        ->get();

    return view('guide.dashboard', compact(
        'totalTours',
        'totalCustomers',
        'weeklyTours',
        'monthlyTours',
        'assignedTours'
    ));
}

    /*
    =========================
    DANH SÁCH GROUP
    =========================
    */
    public function groups()
    {
        $guide_id = auth()->user()->guide->id;

        $groups = Group::where('guide_id', $guide_id)
            ->with(['trip.tour'])
            ->get();

        return view('guide.groups', compact('groups'));
    }

    /*
    =========================
    CẬP NHẬT TRẠNG THÁI GROUP
    =========================
    */
    public function updateProgress(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'progress' => 'required|in:pending,ongoing,completed'
        ]);

        $group->progress = $request->progress;
        $group->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

    /*
    =========================
    DANH SÁCH KHÁCH
    =========================
    */
    public function customers($group_id)
    {
        $customers = BookingCustomer::whereHas('booking',function($q) use ($group_id){
            $q->where('group_id',$group_id);
        })->get();

        return view('guide.customers',compact('customers','group_id'));
    }

    /*
    =========================
    TRANG ĐIỂM DANH
    =========================
    */
    public function attendance($group_id)
    {
        $customers = BookingCustomer::whereHas('booking',function($q) use ($group_id){
            $q->where('group_id',$group_id);
        })->get();

        return view('guide.attendance',compact('customers','group_id'));
    }

    /*
    =========================
    LƯU ĐIỂM DANH
    =========================
    */
    public function saveAttendance(Request $request,$group_id)
    {
        $guide_id = auth()->user()->guide->id;
        $group = Group::findOrFail($group_id);

        $attendance = Attendance::create([
            'trip_id' => $group->trip_id,
            'group_id' => $group->id,
            'guide_id' => $guide_id,
            'attendance_date' => now()->toDateString(),
            'session' => $request->session,
            'note' => $request->note
        ]);

        foreach($request->status as $customer_id => $status){
            AttendanceDetail::create([
                'attendance_id' => $attendance->id,
                'booking_customer_id' => $customer_id,
                'status' => $status,
                'note' => $request->note_customer[$customer_id] ?? null,
                'marked_at' => now()
            ]);
        }

        return redirect()->back()->with('success','Điểm danh thành công');
    }

    /*
    =========================
    CHI TIẾT GROUP
    =========================
    */
    public function groupDetail($id)
    {
        $group = Group::with(['trip.tour', 'bookings.customers'])
            ->findOrFail($id);

        return view('guide.group_detail', compact('group'));
    }
    /*
=========================
LỊCH SỬ TOUR ĐÃ DẪN
=========================
*/
public function history()
{
    $guide_id = auth()->user()->guide->id;

    $groups = Group::where('guide_id', $guide_id)
        ->where('progress', 'completed') // ✅ chỉ lấy tour hoàn thành
        ->with(['trip.tour'])
        ->orderByDesc('id')
        ->get();

    return view('guide.history', compact('groups'));
}

    public function confirm($id)
    {
        $group = Group::findOrFail($id);

        // chỉ cho phép guide của group đó
        if ($group->guide_id != auth()->user()->guide->id) {
            return back()->with('error','Không có quyền');
        }

        $group->update([
            'guide_confirm' => 'accepted'
        ]);

        return back()->with('success','Bạn đã chấp nhận tour');
    }
}
