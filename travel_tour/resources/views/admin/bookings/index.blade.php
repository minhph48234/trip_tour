@extends('admin.layouts.layout')

@section('content_title', 'Danh sách đơn đặt tour')

@section('content')

<div class="booking-container">

<h2 class="page-title">Danh sách Booking</h2>

{{-- ================= SEARCH ================= --}}
<div style="margin-bottom:20px;">

<form method="GET" action="{{ route('admin.bookings.index') }}">

<div style="display:flex; gap:10px; max-width:400px;">

<input type="text"
name="keyword"
value="{{ request('keyword') }}"
placeholder="Tìm theo tên khách hoặc mã booking..."
class="form-control">

<button type="submit" class="btn btn-primary">
Tìm kiếm
</button>

<a href="{{ route('admin.bookings.index') }}"
class="btn btn-secondary">
Reset
</a>

</div>

</form>

</div>

{{-- ================= TABLE ================= --}}
<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Mã booking</th>
<th>Tour</th>
<th>Khách</th>
<th>Số người</th>
<th>Tổng tiền</th>

<th>Tiền cọc</th> {{-- ✅ thêm --}}
<th>Đã thanh toán</th> {{-- ✅ thêm --}}

<th>Trạng thái</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($bookings as $booking)

<tr>

<td>{{ $booking->id }}</td>

<td>{{ $booking->booking_code }}</td>

<td>{{ $booking->tour->name }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->quantity }}</td>

<td>{{ number_format($booking->total_price) }} đ</td>

<td class="text-primary font-weight-bold">
{{ number_format($booking->deposit_amount ?? ($booking->total_price * 0.5)) }} đ
</td>

<td class="text-success font-weight-bold">
{{ number_format($booking->paid_amount ?? 0) }} đ
</td>

<td>

@php
$statusText = match($booking->status){
    'pending' => 'Chờ thanh toán',
    'deposit_paid' => 'Đã đặt cọc',
    'paid' => 'Đã thanh toán đủ',
    'completed' => 'Hoàn thành',
    'canceled' => 'Đã hủy',
    default => 'Không xác định'
};

$statusClass = match($booking->status){
    'pending' => 'badge bg-warning',
    'deposit_paid' => 'badge bg-info',
    'paid' => 'badge bg-success',
    'completed' => 'badge bg-primary',
    'canceled' => 'badge bg-danger',
    default => 'badge bg-secondary'
};
@endphp

<span class="{{ $statusClass }}">
{{ $statusText }}
</span>

</td>

<td>

<a class="btn btn-primary"
href="{{ route('admin.bookings.show',$booking->id) }}">
Chi tiết
</a>

</td>

</tr>

@empty

<tr>
<td colspan="10" style="text-align:center">
Không có dữ liệu
</td>
</tr>

@endforelse

</tbody>

</table>

{{-- ================= PAGINATION ================= --}}
<div class="pagination-wrapper">

{{ $bookings->appends(request()->query())->links() }}

</div>

</div>

@endsection