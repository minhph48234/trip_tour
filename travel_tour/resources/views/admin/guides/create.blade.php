@extends('admin.layouts.layout')

@section('content_title', 'Thêm hướng dẫn viên')

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

<form action="{{ route('admin.guides.store') }}" method="POST">
@csrf

<div class="mb-3">
<label class="form-label">Tên hướng dẫn viên</label>

<input type="text"
       name="name"
       value="{{ old('name') }}"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label class="form-label">Điện thoại</label>

<input type="text"
       name="phone"
       value="{{ old('phone') }}"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>

<input type="email"
       name="email"
       value="{{ old('email') }}"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label class="form-label">Kinh nghiệm (năm)</label>

<input type="number"
       name="experience"
       value="{{ old('experience') }}"
       class="form-control"
       min="0"
       required>
</div>

<div class="alert alert-info">
Tài khoản đăng nhập sẽ được tạo với mật khẩu mặc định: <b>123456</b>
</div>

<button type="submit" class="btn btn-success">
Lưu
</button>

<a href="{{ route('admin.guides.index') }}"
   class="btn btn-secondary">
Quay lại
</a>

</form>

@endsection