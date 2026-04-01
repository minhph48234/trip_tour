@extends('admin.layouts.layout')

@section('content')

<div class="container">

<h2>Chi tiết lịch khởi hành</h2>

<ul class="list-group">

<li class="list-group-item">
<b>Tour:</b> {{ $trip->tour->name }}
</li>

<li class="list-group-item">
<b>Ngày khởi hành:</b> 
{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
</li>

<li class="list-group-item">
<b>Ngày kết thúc:</b> 
{{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}
</li>

<li class="list-group-item">
<b>Số chỗ tối đa:</b> {{ $trip->max_people }}
</li>

<li class="list-group-item">
<b>Đã đặt:</b> {{ $trip->current_people }}
</li>

<li class="list-group-item">

<b>Trạng thái:</b>

@php
$statusText = match($trip->status){
    'open' => 'Đang mở',
    'full' => 'Đã đầy',
    'started' => 'Đang khởi hành',
    'finished' => 'Đã kết thúc',
    default => $trip->status
};

$statusColor = match($trip->status){
    'open' => 'color:green; font-weight:bold',
    'full' => 'color:orange; font-weight:bold',
    'started' => 'color:blue; font-weight:bold',
    'finished' => 'color:red; font-weight:bold',
    default => ''
};
@endphp

<span style="{{ $statusColor }}">
    {{ $statusText }}
</span>

</li>

</ul>

</div>

@endsection