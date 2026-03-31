@extends('admin.layouts.layout')

@section('content_title', 'Thêm danh mục')

@section('content')

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf

    {{-- Tên danh mục --}}
    <div class="mb-3">
        <label class="form-label">Tên danh mục</label>
        <input type="text" 
               name="name" 
               class="form-control" 
               value="{{ old('name') }}"
               required>
    </div>

    {{-- Mô tả --}}
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description"
                  class="form-control"
                  rows="3">{{ old('description') }}</textarea>
    </div>

    {{-- Danh mục cha --}}
    <div class="mb-3">
        <label class="form-label">Danh mục cha</label>
        <select name="parent_id" class="form-select">
            <option value="">-- Không có (Danh mục gốc) --</option>

            @isset($categories)
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            @endisset

        </select>
    </div>

    {{-- Trạng thái --}}
    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="1">Hiện</option>
            <option value="0">Ẩn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Lưu danh mục
    </button>

    <a href="{{ route('admin.categories.index') }}" 
       class="btn btn-secondary">
        Quay lại
    </a>

</form>

@endsection