<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{

    // Danh sách tour
    public function index()
    {
        $tours = Tour::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }


    // Xem chi tiết tour
    public function show($id)
    {
        $tour = Tour::with([
            'category',
            'images',
            'itineraries',
            'trips',
            'reviews'
        ])->findOrFail($id);

        return view('admin.tours.show', compact('tour'));
    }


    // Form tạo tour
    public function create()
    {
        $categories = TourCategory::where('status',1)->get();

        return view('admin.tours.create', compact('categories'));
    }


    // Lưu tour
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'category_id' => 'required',
        'price' => 'required|numeric',
        'child_price' => 'nullable|numeric',
        'max_people' => 'required|integer',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $thumbnail = null;

    if ($request->hasFile('thumbnail')) {

        $thumbnail = $request->file('thumbnail')->store('tours', 'public');

    }

    Tour::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'departure_location' => $request->departure_location,
        'destination' => $request->destination,
        'duration' => $request->duration,
        'transport' => $request->transport,
        'price' => $request->price,
        'child_price' => $request->child_price,
        'max_people' => $request->max_people,
        'description' => $request->description,
        'highlight' => $request->highlight,
        'thumbnail' => $thumbnail,
        'status' => $request->status ?? 1
    ]);

    return redirect()
        ->route('admin.tours.index')
        ->with('success','Thêm tour thành công');
}


    // Form sửa
    public function edit($id)
    {
        $tour = Tour::findOrFail($id);

        $categories = TourCategory::where('status',1)->get();

        return view('admin.tours.edit', compact('tour','categories'));
    }


    // Cập nhật
    public function update(Request $request, $id)
{
    $tour = Tour::findOrFail($id);

    $request->validate([
        'name' => 'required|max:255',
        'category_id' => 'required',
        'price' => 'required|numeric',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    $thumbnail = $tour->thumbnail;

    if ($request->hasFile('thumbnail')) {

        $thumbnail = $request->file('thumbnail')->store('tours', 'public');

    }

    $tour->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'departure_location' => $request->departure_location,
        'destination' => $request->destination,
        'duration' => $request->duration,
        'transport' => $request->transport,
        'price' => $request->price,
        'child_price' => $request->child_price,
        'max_people' => $request->max_people,
        'description' => $request->description,
        'highlight' => $request->highlight,
        'thumbnail' => $thumbnail,
        'status' => $request->status
    ]);

    return redirect()
        ->route('admin.tours.index')
        ->with('success','Cập nhật tour thành công');
}


    // Xoá
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        $tour->delete();

        return redirect()
            ->route('admin.tours.index')
            ->with('success','Xóa tour thành công');
    }

}