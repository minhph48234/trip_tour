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

    public function index()
{

    $groups = Group::with([
        'trip.tour',
        'guide'
    ])
    ->orderBy('id','desc')
    ->paginate(10);

    return view('admin.groups.index',compact('groups'));

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

   public function assignGuide(Request $request,$id)
{

    $group = Group::with('trip')->findOrFail($id);

    $guide_id = $request->guide_id;

    $tripDate = $group->trip->start_date;


    // kiểm tra guide có tour cùng ngày không
    $exists = Group::where('guide_id',$guide_id)
        ->whereHas('trip',function($q) use ($tripDate){
            $q->whereDate('start_date',$tripDate);
        })
        ->exists();


    if($exists){
        return back()->with('error','Hướng dẫn viên đã có tour trong ngày này');
    }


    $group->update([
        'guide_id'=>$guide_id
    ]);

    return back()->with('success','Đã phân công hướng dẫn viên');

}



}