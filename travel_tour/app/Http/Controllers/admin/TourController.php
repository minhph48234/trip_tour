<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{

    public function index(Request $request)
    {
        $query = Tour::with('category');

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $tours = $query->latest()->paginate(10);
        $categories = TourCategory::where('status',1)->get();

        return view('admin.tours.index', compact('tours','categories'));
    }

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

    public function create()
    {
        $categories = TourCategory::where('status',1)->get();
        return view('admin.tours.create', compact('categories'));
    }

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
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('admin.tours.index')
            ->with('success','Thêm tour thành công');
    }

    public function edit($id)
    {
        $tour = Tour::with('itineraries')->findOrFail($id);
        $categories = TourCategory::where('status',1)->get();

        return view('admin.tours.edit', compact('tour','categories'));
    }

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

        // 🔥 xử lý ảnh
        if ($request->hasFile('thumbnail')) {

            // xóa ảnh cũ
            if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
                Storage::disk('public')->delete($tour->thumbnail);
            }

            // lưu ảnh mới
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
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('admin.tours.index')
            ->with('success','Cập nhật tour thành công');
    }

    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        if ($tour->trips()->exists()) {
            return back()->with('error', 'Không thể xoá vì tour đã có lịch khởi hành');
        }

        // xóa ảnh
        if ($tour->thumbnail && Storage::disk('public')->exists($tour->thumbnail)) {
            Storage::disk('public')->delete($tour->thumbnail);
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success','Xóa tour thành công');
    }
}