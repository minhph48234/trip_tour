@extends('admin.layouts.layout')

@section('content_title','Danh sách lịch khởi hành')

@section('content')

<div class="container">

<h2>Quản lý lịch khởi hành</h2>

<a href="{{ route('admin.trips.create') }}" class="btn btn-primary mb-3">
    Thêm lịch khởi hành
</a>

<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Tour</th>
    <th>Ngày khởi hành</th>
    <th>Ngày kết thúc</th>
    <th>Số chỗ</th>
    <th>Đã đặt</th>
    <th>Trạng thái</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($trips as $trip)

<tr>
<td>{{ $trip->id }}</td>

<td>{{ $trip->tour->name }}</td>

<td>{{ $trip->start_date }}</td>

<td>{{ $trip->end_date }}</td>

<td>{{ $trip->max_people }}</td>

<td>{{ $trip->current_people }}</td>

<td>{{ $trip->status }}</td>

<td>

<a href="{{ route('admin.trips.show',$trip->id) }}" class="btn btn-info btn-sm">Xem</a>

<a href="{{ route('admin.trips.edit',$trip->id) }}" class="btn btn-warning btn-sm">Sửa</a>

<form action="{{ route('admin.trips.destroy',$trip->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">Xóa</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $trips->links() }}

</div>

@endsection