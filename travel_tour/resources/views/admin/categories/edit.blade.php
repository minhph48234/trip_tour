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
            <option value="active" @selected($category->status == 'active')>Hiển thị</option>
            <option value="inactive" @selected($category->status == 'inactive')>Ẩn</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-select">
            @foreach($listCategory as $cat)
            <option value="{{ $cat->id }}" @selected($cat->id == $category->parent_id)> {{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        Quay lại
    </a>

</form>

@endsection