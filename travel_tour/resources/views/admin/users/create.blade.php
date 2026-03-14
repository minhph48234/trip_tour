@extends('admin.layouts.layout')

@section('page_title', 'Thêm người dùng')

@section('content')

<form method="POST"
      action="{{ route('admin.users.store') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="mb-3">
        <label>Tên</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name') }}"
               required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email') }}"
               required>
    </div>

    <div class="mb-3">
        <label>Avatar</label>
        <input type="file"
               name="avatar"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Mật khẩu</label>
        <input type="password"
               name="password"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label>Xác nhận mật khẩu</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label>Vai trò</label>
        <select name="role" class="form-select">
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="guide">Guide</option>
        </select>
    </div>

    <button class="btn btn-primary">Lưu</button>

    <a href="{{ route('admin.users.index') }}"
       class="btn btn-secondary">
       Quay lại
    </a>

</form>

@endsection