@extends('admin.layouts.layout')

@section('content_title', 'Danh sách hướng dẫn viên')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

<h4 class="mb-0">Danh sách hướng dẫn viên</h4>

<a href="{{ route('admin.guides.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Thêm hướng dẫn viên
</a>

</div>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

<table class="table table-bordered table-hover align-middle">

<thead class="table-light">
<tr>
<th width="60">ID</th>
<th>User ID</th>
<th>Tên</th>
<th>Điện thoại</th>
<th>Email</th>
<th>Kinh nghiệm</th>
<th>Trạng thái</th>
<th width="160">Hành động</th>
</tr>
</thead>

<tbody>

@forelse($guides as $guide)

<tr>

<td>{{ $guide->id }}</td>

<td>{{ $guide->user_id }}</td>

<td>{{ $guide->name }}</td>

<td>{{ $guide->phone }}</td>

<td>{{ $guide->email }}</td>

<td>{{ $guide->experience }} năm</td>

<td>
@if($guide->status)
<span class="badge bg-success">Hoạt động</span>
@else
<span class="badge bg-danger">Ngưng</span>
@endif
</td>

<td>

<a href="{{ route('admin.guides.edit', $guide->id) }}"
class="btn btn-sm btn-warning">
<i class="fas fa-edit"></i>
</a>

<form action="{{ route('admin.guides.destroy', $guide->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button onclick="return confirm('Bạn chắc chắn muốn xoá?')"
class="btn btn-sm btn-danger">
<i class="fas fa-trash"></i>
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center">
Không có dữ liệu
</td>
</tr>

@endforelse

</tbody>

</table>

@endsection