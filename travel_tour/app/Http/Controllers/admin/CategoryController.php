<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // Danh sách danh mục
    public function index()
    {
        $categories = TourCategory::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    // Form thêm
    public function create()

    {
        $categories = TourCategory::All();
        return view('admin.categories.create', compact('categories'));
    }

    // Lưu dữ liệu
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255'
    ]);

    TourCategory::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'parent_id' => $request->parent_id,
        'status' => $request->status
    ]);

    return redirect()->route('admin.categories.index')
        ->with('success','Thêm danh mục thành công');
}

    // Form sửa
    public function edit($id)
    {
        $category = TourCategory::findOrFail($id);
        $listCategory = TourCategory::All();
        return view('admin.categories.edit', compact('category' ,'listCategory'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $category = TourCategory::findOrFail($id);
    
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:tour_categories,id'
        ]);
    
        // ❗ tránh chọn chính nó làm cha
        if ($request->parent_id == $id) {
            return back()->with('error', 'Không thể chọn chính nó làm danh mục cha');
        }
    
        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'parent_id' => $request->parent_id
        ]);
    
        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật thành công');
    }
    // Xoá
    public function destroy($id)
    {
        $category = TourCategory::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success','Xoá thành công');
    }

}