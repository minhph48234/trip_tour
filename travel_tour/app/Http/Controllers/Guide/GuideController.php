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
        // ⚠️ Nếu guide_id = user_id thì dùng Auth::id()
        $guideId = Auth::id();

        /*
        =========================
        DANH SÁCH GROUP
        =========================
        */
        $groups = Group::with(['trip.tour','bookings'])
            ->where('guide_id', $guideId)
            ->get();

        /*
        =========================
        TOUR HÔM NAY
        =========================
        */
        $todayTours = Group::with(['trip.tour'])
            ->where('guide_id', $guideId)
            ->whereHas('trip', function($q){
                $q->whereDate('start_date', now());
            })
            ->get();

        /*
        =========================
        TOUR ĐANG DIỄN RA
        =========================
        */
        $ongoingTours = Group::where('guide_id', $guideId)
            ->whereHas('trip', function($q){
                $q->whereDate('start_date','<=', now())
                  ->whereDate('end_date','>=', now());
            })
            ->count();

        /*
        =========================
        TỔNG KHÁCH
        =========================
        */
        $totalCustomers = Booking::whereHas('group', function($q) use ($guideId){
            $q->where('guide_id', $guideId);
        })->sum('quantity');

        /*
        =========================
        TỔNG TOUR
        =========================
        */
        $totalTours = $groups->count();

        /*
        =========================
        GROUP MỚI NHẤT (FIX LỖI Ở ĐÂY)
        =========================
        */
        $latestGroups = Group::with(['trip.tour'])
            ->where('guide_id', $guideId)
            ->orderByDesc('id') // ✅ FIX: thay latest()
            ->limit(5)
            ->get();

        /*
        =========================
        RETURN VIEW
        =========================
        */
        return view('guide.dashboard', compact(
            'totalTours',
            'totalCustomers',
            'ongoingTours',
            'todayTours',
            'latestGroups'
        ));
    }

    /*
    =========================
    DANH SÁCH GROUP
    =========================
    */
    // group được phân công
public function groups()
{

$guide_id = auth()->user()->guide->id;

$groups = Group::where('guide_id',$guide_id)
            ->with('trip.tour')
            ->get();

return view('guide.groups',compact('groups'));

}


// danh sách khách
public function customers($group_id)
{

$customers = BookingCustomer::whereHas('booking',function($q) use ($group_id){
    $q->where('group_id',$group_id);
})->get();

return view('guide.customers',compact('customers','group_id'));

}


// trang điểm danh
public function attendance($group_id)
{

$customers = BookingCustomer::whereHas('booking',function($q) use ($group_id){
    $q->where('group_id',$group_id);
})->get();

return view('guide.attendance',compact('customers','group_id'));

}



/*
|--------------------------------------------------------------------------
| LƯU ĐIỂM DANH
|--------------------------------------------------------------------------
*/

public function saveAttendance(Request $request,$group_id)
{

$guide_id = auth()->user()->guide->id;

$group = Group::findOrFail($group_id);


/*
|--------------------------------------------------------------------------
| TẠO BẢN GHI ĐIỂM DANH
|--------------------------------------------------------------------------
*/

$attendance = Attendance::create([

    'trip_id' => $group->trip_id,
    'group_id' => $group->id,
    'guide_id' => $guide_id,
    'attendance_date' => now()->toDateString(),
    'session' => $request->session,
    'note' => $request->note

]);


/*
|--------------------------------------------------------------------------
| LƯU CHI TIẾT TỪNG KHÁCH
|--------------------------------------------------------------------------
*/

foreach($request->status as $customer_id => $status){

AttendanceDetail::create([

    'attendance_id' => $attendance->id,
    'booking_customer_id' => $customer_id,
    'status' => $status,
    'note' => $request->note_customer[$customer_id] ?? null,
    'marked_at' => now()

]);

}


return redirect()
    ->back()
    ->with('success','Điểm danh thành công');

}

public function groupDetail($id)
{
    $group = Group::with(['trip.tour', 'bookings.customers'])
        ->findOrFail($id);

    return view('guide.group_detail', compact('group'));
}
}