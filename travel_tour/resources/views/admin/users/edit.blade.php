@extends('admin.layouts.layout')

@section('page_title','Cập nhật người dùng')

@section('content')

<form method="POST"
      action="{{ route('admin.users.update',$user) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tên</label>
        <input type="text"
               name="name"
               value="{{ $user->name }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email"
               name="email"
               value="{{ $user->email }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Avatar</label>
        <input type="file"
               name="avatar"
               class="form-control">

        <br>

        @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}" width="80">
        @endif
    </div>

    <div class="mb-3">
        <label>Mật khẩu mới (nếu đổi)</label>
        <input type="password"
               name="password"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Vai trò</label>
        <select name="role" class="form-select">

            <option value="user"
                {{ $user->role == 'user' ? 'selected' : '' }}>
                User
            </option>

            <option value="admin"
                {{ $user->role == 'admin' ? 'selected' : '' }}>
                Admin
            </option>

            <option value="guide"
                {{ $user->role == 'guide' ? 'selected' : '' }}>
                Guide
            </option>

        </select>
    </div>

    <button class="btn btn-primary">
        Cập nhật
    </button>

    <a href="{{ route('admin.users.index') }}"
       class="btn btn-secondary">
       Quay lại
    </a>

</form>

@endsection