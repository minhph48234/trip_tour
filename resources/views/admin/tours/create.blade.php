@extends('admin.layouts.layout')

@section('content_title', 'Thêm tour mới')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card shadow-sm border-0">
<div class="card-body">

<div class="row">

<div class="col-md-8">

<div class="mb-3">
<label class="form-label">Tên tour</label>
<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
</div>

<div class="mb-3">
<label class="form-label">Danh mục</label>
<select name="category_id" class="form-select" required>
<option value="">-- Chọn danh mục --</option>
@foreach($categories as $category)
<option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
</select>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Điểm khởi hành</label>
<input type="text" name="departure_location" class="form-control" value="{{ old('departure_location') }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Điểm đến</label>
<input type="text" name="destination" class="form-control" value="{{ old('destination') }}">
</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Thời gian</label>
<input type="text" name="duration" class="form-control" placeholder="VD: 3 ngày 2 đêm">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Phương tiện</label>
<input type="text" name="transport" class="form-control" placeholder="Máy bay / Xe khách / Tàu">
</div>

</div>

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label">Giá người lớn</label>
<input type="number" name="price" class="form-control" required>
</div>

<div class="col-md-4 mb-3">
<label class="form-label">Giá trẻ em</label>
<input type="number" name="child_price" class="form-control">
</div>

<div class="col-md-4 mb-3">
<label class="form-label">Số người tối đa</label>
<input type="number" name="max_people" class="form-control" required>
</div>

</div>

<div class="mb-3">
<label class="form-label">Tour nổi bật</label>
<select name="highlight" class="form-select">
<option value="0">Không</option>
<option value="1">Có</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Mô tả</label>
<textarea name="description" rows="5" class="form-control"></textarea>
</div>

</div>


<div class="col-md-4">

<div class="mb-3">
<label class="form-label">Ảnh đại diện</label>
<input type="file" name="thumbnail" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Trạng thái</label>
<select name="status" class="form-select">
<option value="1">Hiển thị</option>
<option value="0">Ẩn</option>
</select>
</div>

</div>

</div>

</div>

<div class="card-footer text-end">

<button type="submit" class="btn btn-success px-4">
<i class="fa fa-save me-1"></i> Lưu tour
</button>

<a href="{{ route('admin.tours.index') }}" class="btn btn-secondary px-4">
Quay lại
</a>

</div>

</div>

</form>

@endsection