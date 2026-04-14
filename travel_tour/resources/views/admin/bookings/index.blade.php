@extends('admin.layouts.layout')

@section('content_title', 'Danh sách đơn đặt tour')

@section('content')

<div class="container-fluid">

<h4 class="mb-4 fw-bold">Danh sách Booking</h4>

{{-- SEARCH --}}
<form method="GET" class="mb-3">
    <div class="d-flex gap-2" style="max-width:400px">
        <input type="text" name="keyword" value="{{ request('keyword') }}"
               class="form-control"
               placeholder="Tên khách hoặc mã booking">

        <button class="btn btn-primary">Tìm</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

<table class="table table-bordered table-hover align-middle text-center">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Mã</th>
<th>Tour</th>
<th>Khách</th>
<th>SL</th>
<th>Tổng tiền</th>
<th>Đã thanh toán</th>
<th>Thanh toán</th>
<th>Admin</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@forelse($bookings as $booking)

@php
$totalPaid = $booking->payments->where('status','paid')->sum('amount');

// 🔥 CHECK ADMIN STATUS
$hasFullConfirm = $booking->payments
    ->where('admin_confirm_status','confirmed')
    ->count();

$hasDepositConfirm = $booking->payments
    ->where('admin_confirm_status','deposit_confirmed')
    ->count();
@endphp

<tr>

<td>{{ $booking->id }}</td>

<td>{{ $booking->booking_code }}</td>

<td>{{ $booking->tour->name }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->quantity }}</td>

<td class="text-danger fw-bold">
{{ number_format($booking->total_price) }} đ
</td>

<td class="text-success fw-bold">
{{ number_format($totalPaid) }} đ
</td>

{{-- TRẠNG THÁI THANH TOÁN --}}
<td>
    @if($totalPaid == 0)
        <span class="badge bg-warning">Chưa thanh toán</span>
    @elseif($totalPaid < $booking->total_price)
        <span class="badge bg-info">Đã cọc</span>
    @else
        <span class="badge bg-success">Đã thanh toán đủ</span>
    @endif
</td>

{{-- 🔥 ADMIN CONFIRM --}}
<td>
    @if($hasFullConfirm > 0)
        <span class="badge bg-success">✔ Đã xác nhận full</span>

    @elseif($hasDepositConfirm > 0)
        <span class="badge bg-info text-dark">💰 Đã xác nhận cọc</span>

    @else
        <span class="badge bg-warning">⏳ Chờ xác nhận</span>
    @endif
</td>

<td>
    <a href="{{ route('admin.bookings.show',$booking->id) }}"
       class="btn btn-sm btn-primary">
        Chi tiết
    </a>
</td>

</tr>

@empty
<tr>
<td colspan="10">Không có dữ liệu</td>
</tr>
@endforelse

</tbody>

</table>

{{ $bookings->links() }}

</div>

@endsection