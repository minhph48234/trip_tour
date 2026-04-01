<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourItinerary;
use Illuminate\Http\Request;

class TourItineraryController extends Controller
{
    public function store(Request $request, $tourId)
    {
        $request->validate([
            'day' => 'required|integer|min:1',
            'title' => 'required',
        ]);

        TourItinerary::create([
            'tour_id' => $tourId,
            'day' => $request->day,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success','Thêm lịch trình thành công');
    }

    public function destroy($id)
    {
        TourItinerary::destroy($id);

        return back()->with('success','Xoá thành công');
    }
}