@extends('admin.layouts.layout')

@section('content_title', 'Danh sách hướng dẫn viên')

@section('content')

<h2>Chi tiết đoàn</h2>

<p>Tour: {{ $group->trip->tour->name }}</p>

<p>Ngày khởi hành: {{ $group->trip->start_date }}</p>

<p>Số người:

{{ $group->current_people }}/{{ $group->max_people }}

</p>

<h3>Phân công hướng dẫn viên</h3>

<form class="form-horizontal" action="{{ route('admin.groups.assignGuide',$group->id) }}" method="POST">

@csrf
@method('PUT')

<select name="guide_id">

@foreach($guides as $guide)

<option value="{{ $guide->id }}">

{{ $guide->name }}

</option>

@endforeach

</select>

<button type="submit">

Phân công

</button>

</form>



<h3>Danh sách booking</h3>

<table border="1" class="table table-bordered">

<tr>

<th>Mã booking</th>
<th>Khách</th>
<th>Số người</th>

</tr>

@foreach($group->bookings as $booking)

<tr>

<td>{{ $booking->booking_code }}</td>

<td>{{ $booking->customer_name }}</td>

<td>{{ $booking->quantity }}</td>

</tr>

@endforeach

</table>

@endsection