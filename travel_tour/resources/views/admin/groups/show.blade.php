@extends('admin.layouts.layout')

@section('content_title','Chi tiết đoàn')

@section('content')

<h3>Thông tin đoàn</h3>

<p><b>Tour:</b> {{ $group->trip->tour->name }}</p>
<p><b>Ngày:</b> {{ \Carbon\Carbon::parse($group->trip->start_date)->format('d/m/Y') }}</p>

<p><b>Guide hiện tại:</b> 
@if($group->guide)
    {{ $group->guide->name }}
@else
    Chưa có
@endif
</p>

<hr>

<h4>Phân công guide</h4>

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.groups.assignGuide',$group->id) }}" method="POST">
@csrf
@method('PUT')

<select name="guide_id" class="form-control mb-2">

@foreach($guides as $guide)

<option value="{{ $guide->id }}">

{{ $guide->name }} 

(
@if($guide->status == 'available')
    Sẵn sàng
@elseif($guide->status == 'busy')
    Đang bận
@else
    Ngừng hoạt động
@endif
)

</option>

@endforeach

</select>

<button class="btn btn-primary">Phân công</button>

</form>

<hr>

<h4>Danh sách booking</h4>

<table class="table table-bordered">

<tr>
<th>Mã</th>
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