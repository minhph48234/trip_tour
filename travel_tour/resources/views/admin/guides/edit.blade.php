@extends('admin.layouts.layout')

@section('content_title', 'Cập nhật hướng dẫn viên')

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

@if(session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

<form action="{{ route('admin.guides.update', $guide->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label class="form-label">Tên</label>

<input type="text"
       name="name"
       value="{{ old('name', $guide->name) }}"
       class="form-control"
       required>

</div>

<div class="mb-3">
<label class="form-label">Điện thoại</label>

<input type="text"
       name="phone"
       value="{{ old('phone', $guide->phone) }}"
       class="form-control"
       required>

</div>

<div class="mb-3">
<label class="form-label">Email</label>

<input type="email"
       name="email"
       value="{{ old('email', $guide->email) }}"
       class="form-control"
       required>

</div>

<div class="mb-3">
<label class="form-label">Kinh nghiệm (năm)</label>

<input type="number"
       name="experience"
       value="{{ old('experience', $guide->experience) }}"
       class="form-control"
       min="0"
       required>

</div>

<div class="mb-3">
<label class="form-label">Trạng thái</label>

<select name="status" class="form-control">

<option value="1"
{{ $guide->status == 1 ? 'selected' : '' }}>
Hoạt động
</option>

<option value="0"
{{ $guide->status == 0 ? 'selected' : '' }}>
Ngưng
</option>

</select>

</div>

<button type="submit" class="btn btn-primary">
Cập nhật
</button>

<a href="{{ route('admin.guides.index') }}"
class="btn btn-secondary">
Quay lại
</a>

</form>

@endsection