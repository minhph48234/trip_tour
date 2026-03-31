@extends('admin.layouts.layout')


@section('content')

<div class="container">

<h2>Chi tiết lịch khởi hành</h2>

<ul class="list-group">

<li class="list-group-item">
Tour: {{ $trip->tour->name }}
</li>

<li class="list-group-item">
Ngày khởi hành: {{ $trip->start_date }}
</li>

<li class="list-group-item">
Ngày kết thúc: {{ $trip->end_date }}
</li>

<li class="list-group-item">
Số chỗ tối đa: {{ $trip->max_people }}
</li>

<li class="list-group-item">
Đã đặt: {{ $trip->current_people }}
</li>

<li class="list-group-item">
Trạng thái: {{ $trip->status }}
</li>

</ul>

</div>

@endsection