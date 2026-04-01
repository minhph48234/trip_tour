<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TripController extends Controller
{

    public function index(Request $request)
{
    $query = Trip::with('tour');

    // ================= FILTER =================
    if ($request->filled('start_date')) {
        $query->whereDate('start_date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('end_date', '<=', $request->end_date);
    }

    $trips = $query->get();

    // ================= AUTO UPDATE STATUS =================
    foreach ($trips as $trip) {

        $today = Carbon::today();

        if ($today > Carbon::parse($trip->end_date)) {
            $trip->status = 'finished';
        }

        elseif (
            $today >= Carbon::parse($trip->start_date) &&
            $today <= Carbon::parse($trip->end_date)
        ) {
            $trip->status = 'started';
        }

        else {
            if ($trip->current_people >= $trip->max_people) {
                $trip->status = 'full';
            } else {
                $trip->status = 'open';
            }
        }

        $trip->save();
    }

    // load lại có paginate
    $trips = $query->latest()->paginate(10);

    return view('admin.trips.index', compact('trips'));
}


    public function create()
    {
        $tours = Tour::all();

        return view('admin.trips.create', compact('tours'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_people' => 'required|integer|min:1',
            'status' => 'required'
        ]);

        Trip::create([
            'tour_id' => $request->tour_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_people' => $request->max_people,
            'current_people' => 0,
            'status' => $request->status
        ]);

        return redirect()->route('admin.trips.index')
            ->with('success','Tạo lịch khởi hành thành công');
    }


    public function show(string $id)
    {
        $trip = Trip::with('tour')->findOrFail($id);

        return view('admin.trips.show', compact('trip'));
    }


    public function edit(string $id)
    {
        $trip = Trip::findOrFail($id);
        $tours = Tour::all();

        return view('admin.trips.edit', compact('trip','tours'));
    }


    public function update(Request $request, string $id)
    {
        $trip = Trip::findOrFail($id);

        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_people' => 'required|integer|min:1',
            'status' => 'required'
        ]);

        $trip->update($request->all());

        return redirect()->route('admin.trips.index')
            ->with('success','Cập nhật thành công');
    }


    public function destroy(string $id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success','Xóa lịch khởi hành thành công');
    }
}