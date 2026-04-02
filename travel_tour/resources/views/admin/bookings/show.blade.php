@extends('admin.layouts.layout')

@section('content_title', 'Chi tiết đơn đặt tour')

@section('content')

<div class="container">

<h4 class="mb-4 fw-bold">Chi tiết Booking</h4>

@php
$totalPaid = $booking->payments->where('status','paid')->sum('amount');

$adminConfirmed = $booking->payments
    ->where('admin_confirm_status','confirmed')
    ->count();
@endphp

<div class="card p-4 shadow-sm mb-4">

<p><b>Mã booking:</b> {{ $booking->booking_code }}</p>
<p><b>Tour:</b> {{ $booking->tour->name }}</p>
<p><b>Khách:</b> {{ $booking->customer_name }}</p>
<p><b>SĐT:</b> {{ $booking->customer_phone }}</p>
<p><b>Số người:</b> {{ $booking->quantity }}</p>

<hr>

<p>
<b>Tổng tiền:</b>
<span class="text-danger fw-bold">
{{ number_format($booking->total_price) }} đ
</span>
</p>

<p>
<b>Đã thanh toán:</b>
<span class="text-success fw-bold">
{{ number_format($totalPaid) }} đ
</span>
</p>

<p>
<b>Còn lại:</b>
<span class="text-warning fw-bold">
{{ number_format($booking->total_price - $totalPaid) }} đ
</span>
</p>

<hr>

{{-- STATUS --}}
<p>
<b>Trạng thái thanh toán:</b>

@if($totalPaid == 0)
    <span class="badge bg-warning">Chưa thanh toán</span>
@elseif($totalPaid < $booking->total_price)
    <span class="badge bg-info">Đã đặt cọc</span>
@else
    <span class="badge bg-success">Đã thanh toán đủ</span>
@endif

</p>

<p>
<b>Trạng thái admin:</b>

@if($adminConfirmed > 0)
    <span class="badge bg-success">Đã xác nhận</span>
@else
    <span class="badge bg-warning">Chờ xác nhận</span>
@endif

</p>

</div>

{{-- DANH SÁCH THANH TOÁN --}}
<div class="card p-4 shadow-sm mb-4">

<h5 class="mb-3">Lịch sử thanh toán</h5>

<table class="table table-bordered text-center">
<tr>
<th>Loại</th>
<th>Số tiền</th>
<th>Trạng thái</th>
<th>Admin</th>
<th>Thời gian</th>
</tr>

@foreach($booking->payments as $p)
<tr>
<td>{{ $p->type_text }}</td>

<td class="text-danger fw-bold">
{{ number_format($p->amount) }} đ
</td>

<td>
<span class="badge bg-{{ $p->status_color }}">
{{ $p->status_text }}
</span>
</td>

<td>
<span class="badge bg-{{ $p->admin_confirm_color }}">
{{ $p->admin_confirm_text }}
</span>
</td>

<td>
{{ optional($p->paid_at)->format('d/m/Y H:i') }}
</td>
</tr>
@endforeach

</table>

</div>

{{-- KHÁCH --}}
<div class="card p-4 shadow-sm mb-4">

<h5 class="mb-3">Danh sách khách</h5>

<table class="table table-bordered text-center">
<tr>
<th>Tên</th>
<th>Giới tính</th>
<th>Loại</th>
</tr>

@foreach($booking->customers as $c)
<tr>
<td>{{ $c->name }}</td>
<td>{{ $c->gender == 'male' ? 'Nam' : 'Nữ' }}</td>
<td>{{ $c->type == 'adult' ? 'Người lớn' : 'Trẻ em' }}</td>
</tr>
@endforeach

</table>

</div>

{{-- UPDATE STATUS --}}
<div class="card p-4 shadow-sm">

<h5 class="mb-3">Cập nhật trạng thái</h5>

<form method="POST" action="{{ route('admin.bookings.status',$booking->id) }}">
@csrf
@method('PUT')

<select name="status" class="form-control mb-3" style="max-width:300px">

<option value="pending" {{ $booking->status=='pending' ? 'selected' : '' }}>Chờ thanh toán</option>
<option value="deposit_paid" {{ $booking->status=='deposit_paid' ? 'selected' : '' }}>Đã đặt cọc</option>
<option value="paid" {{ $booking->status=='paid' ? 'selected' : '' }}>Đã thanh toán đủ</option>
<option value="completed" {{ $booking->status=='completed' ? 'selected' : '' }}>Hoàn thành</option>
<option value="canceled" {{ $booking->status=='canceled' ? 'selected' : '' }}>Đã hủy</option>

</select>

<button class="btn btn-primary">Cập nhật</button>

</form>

</div>

</div>

@endsection