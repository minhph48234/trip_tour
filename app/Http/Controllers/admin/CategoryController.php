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
        return view('admin.categories.create');
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

        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật
    public function update(Request $request,$id)
    {
        $category = TourCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success','Cập nhật thành công');
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