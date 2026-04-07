@extends('admin.layouts.layout')

@section('page_title','Cập nhật danh mục')

@section('content')

<form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input 
            type="text" 
            name="name" 
            value="{{ old('name', $category->name) }}" 
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1" @selected($category->status == 1)>Hiển thị</option>
            <option value="0" @selected($category->status == 0)>Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        Quay lại
    </a>

</form>

@endsection