@extends('admin.layouts.layout')

@section('content_title', 'Cập nhật tour')

@section('content')

<form action="{{ route('admin.tours.update', $tour->id) }}" 
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên tour</label>
        <input type="text" name="name"
               value="{{ old('name', $tour->name) }}"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Danh mục</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $category->id == old('category_id', $tour->category_id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Điểm khởi hành</label>
        <input type="text" name="departure_location"
               value="{{ old('departure_location', $tour->departure_location) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Điểm đến</label>
        <input type="text" name="destination"
               value="{{ old('destination', $tour->destination) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Thời gian</label>
        <input type="text" name="duration"
               value="{{ old('duration', $tour->duration) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Phương tiện</label>
        <input type="text" name="transport"
               value="{{ old('transport', $tour->transport) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Giá người lớn</label>
        <input type="number" name="price"
               value="{{ old('price', $tour->price) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Giá trẻ em</label>
        <input type="number" name="child_price"
               value="{{ old('child_price', $tour->child_price) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Số người tối đa</label>
        <input type="number" name="max_people"
               value="{{ old('max_people', $tour->max_people) }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Highlight</label>
        <textarea name="highlight"
                  class="form-control"
                  rows="3">{{ old('highlight', $tour->highlight) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description"
                  class="form-control"
                  rows="4">{{ old('description', $tour->description) }}</textarea>
    </div>


    {{-- ẢNH TOUR --}}
    <div class="mb-3">
        <label>Ảnh đại diện</label>

        <input type="file"
               name="thumbnail"
               class="form-control">

        {{-- hiển thị ảnh cũ --}}
        @if($tour->thumbnail)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$tour->thumbnail) }}"
                     width="200"
                     class="img-thumbnail">
            </div>
        @endif

    </div>


    <div class="mb-3">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="1" {{ $tour->status == 1 ? 'selected' : '' }}>
                Hiển thị
            </option>
            <option value="0" {{ $tour->status == 0 ? 'selected' : '' }}>
                Ẩn
            </option>
        </select>
    </div>

    <button class="btn btn-primary">
        Cập nhật
    </button>

    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">
        Quay lại
    </a>

</form>

@endsection