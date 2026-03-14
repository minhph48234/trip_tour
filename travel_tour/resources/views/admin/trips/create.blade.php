@extends('admin.layouts.layout')


@section('content')

<div class="container">

<h2>Thêm lịch khởi hành</h2>

<form action="{{ route('admin.trips.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Tour</label>
<select name="tour_id" class="form-control">

@foreach($tours as $tour)
<option value="{{ $tour->id }}">{{ $tour->name }}</option>
@endforeach

</select>
</div>


<div class="mb-3">
<label>Ngày khởi hành</label>
<input type="date" name="start_date" class="form-control">
</div>


<div class="mb-3">
<label>Ngày kết thúc</label>
<input type="date" name="end_date" class="form-control">
</div>


<div class="mb-3">
<label>Số người tối đa</label>
<input type="number" name="max_people" class="form-control">
</div>


<div class="mb-3">
<label>Trạng thái</label>

<select name="status" class="form-control">

<option value="open">Mở</option>
<option value="closed">Đóng</option>

</select>

</div>

<button class="btn btn-success">Thêm</button>

</form>

</div>

@endsection