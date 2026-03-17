<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\BookingCustomer;
use App\Models\Attendance;
use App\Models\AttendanceDetail;

class GuideController extends Controller
{

// dashboard
public function dashboard()
{
    return view('guide.dashboard');
}


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

// lịch sử tour đã dẫn
public function history()
{
    $groups = \App\Models\Group::with(['trip.tour'])
        ->where('guide_id', auth()->id())
        ->where('status', 'completed') // hoặc done
        ->orderBy('id','desc')
        ->get();

    return view('guide.history', compact('groups'));
}

}