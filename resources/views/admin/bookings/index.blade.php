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

<td>

@php
$statusText = match($booking->status){
    'pending' => 'Chờ xử lý',
    'paid' => 'Đã thanh toán',
    'cancelled' => 'Đã hủy',
    'completed' => 'Hoàn thành',
    default => $booking->status
};
@endphp

<span class="status {{ $booking->status }}">
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
<td colspan="8" style="text-align:center">
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