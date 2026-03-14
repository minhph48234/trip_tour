@extends('admin.layouts.layout')

@section('content_title', 'Danh sách đơn đặt tour')

@section('content')

<h2>Chi tiết Booking</h2>

<p>Mã booking: {{ $booking->booking_code }}</p>
<p>Tour: {{ $booking->tour->name }}</p>
<p>Khách: {{ $booking->customer_name }}</p>
<p>SĐT: {{ $booking->customer_phone }}</p>
<p>Số người: {{ $booking->quantity }}</p>
<p>Tổng tiền: {{ number_format($booking->total_price) }}</p>

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
<td>{{ $customer->gender }}</td>
<td>{{ $customer->type }}</td>

</tr>

@endforeach

</table>

<h3>Đổi trạng thái</h3>

<form action="{{ route('admin.bookings.status',$booking->id) }}" method="POST">

@csrf
@method('PUT')

<select name="status">

<option value="pending">Chờ Xác Nhận</option>
<option value="confirmed">Xác nhận</option>
<option value="cancelled">Huỷ</option>

</select>

<button type="submit">

Cập nhật

</button>

</form>

@endsection