@extends('admin.layouts.layout')

@section('content_title', 'Chi tiết đơn đặt tour')

@section('content')

<h2>Chi tiết Booking</h2>

<p><b>Mã booking:</b> {{ $booking->booking_code }}</p>
<p><b>Tour:</b> {{ $booking->tour->name }}</p>
<p><b>Khách:</b> {{ $booking->customer_name }}</p>
<p><b>SĐT:</b> {{ $booking->customer_phone }}</p>
<p><b>Số người:</b> {{ $booking->quantity }}</p>

<p>
    <b>Tổng tiền:</b> 
    <span style="color:red; font-weight:bold">
        {{ number_format($booking->total_price) }} đ
    </span>
</p>



<p>
    <b>Đã thanh toán:</b> 
    <span style="color:green; font-weight:bold">
        {{ number_format($booking->paid_amount) }} đ
    </span>
</p>

{{-- ================= TRẠNG THÁI ================= --}}
@php
$statusText = match($booking->status){
    'pending' => 'Chờ thanh toán',
    'deposit_paid' => 'Đã đặt cọc',
    'paid' => 'Đã thanh toán đủ',
    'completed' => 'Hoàn thành',
    'canceled' => 'Đã hủy',
    default => $booking->status
};

$statusColor = match($booking->status){
    'pending' => 'color:orange',
    'deposit_paid' => 'color:blue',
    'paid' => 'color:green',
    'completed' => 'color:darkgreen',
    'canceled' => 'color:red',
    default => 'color:black'
};
@endphp

<p>
    <b>Trạng thái:</b> 
    <span style="font-weight:bold; {{ $statusColor }}">
        {{ $statusText }}
    </span>
</p>

<hr>

{{-- ================= DANH SÁCH KHÁCH ================= --}}
<h3>Danh sách khách</h3>

<table border="1" class="table table-bordered">

<tr>
<th>Tên</th>
<th>Giới tính</th>
<th>Loại</th>
</tr>

@foreach($booking->customers as $customer)

<tr>

<td>{{ $customer->name }}</td>

<td>
@php
$genderText = match($customer->gender){
    'male' => 'Nam',
    'female' => 'Nữ',
    default => $customer->gender
};
@endphp
{{ $genderText }}
</td>

<td>
@php
$typeText = match($customer->type){
    'adult' => 'Người lớn',
    'child' => 'Trẻ em',
    default => $customer->type
};
@endphp
{{ $typeText }}
</td>

</tr>

@endforeach

</table>

<hr>

{{-- ================= ĐỔI TRẠNG THÁI ================= --}}
<h3>Đổi trạng thái</h3>

<form action="{{ route('admin.bookings.status',$booking->id) }}" method="POST">

@csrf
@method('PUT')

<select name="status" class="form-control" style="max-width:300px; margin-bottom:10px">

<option value="pending" {{ $booking->status=='pending' ? 'selected' : '' }}>
Chờ thanh toán
</option>

<option value="deposit_paid" {{ $booking->status=='deposit_paid' ? 'selected' : '' }}>
Đã đặt cọc
</option>

<option value="paid" {{ $booking->status=='paid' ? 'selected' : '' }}>
Đã thanh toán đủ
</option>

<option value="completed" {{ $booking->status=='completed' ? 'selected' : '' }}>
Hoàn thành
</option>

<option value="canceled" {{ $booking->status=='canceled' ? 'selected' : '' }}>
Đã hủy
</option>

</select>

<button type="submit" class="btn btn-primary">
Cập nhật
</button>

</form>

@endsection