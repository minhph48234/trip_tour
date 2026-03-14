@extends('admin.layouts.layout')

@section('content_title', 'Danh sách đơn đặt tour')

@section('content')

<div class="booking-container">

<h2 class="page-title">Danh sách Booking</h2>

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

@foreach($bookings as $booking)

<tr>

<td>{{ $booking->id }}</td>

<td>{{ $booking->booking_code }}</td>

<td>{{ $booking->tour->name }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->quantity }}</td>

<td>{{ number_format($booking->total_price) }} đ</td>

<td>
<span class="status {{ $booking->status }}">
{{ $booking->status }}
</span>
</td>

<td>

<a class="btn-view"
href="{{ route('admin.bookings.show',$booking->id) }}">
Chi tiết
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="pagination-wrapper">
{{ $bookings->links() }}
</div>

</div>

@endsection