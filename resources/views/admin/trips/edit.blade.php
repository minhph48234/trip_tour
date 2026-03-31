@extends('admin.layouts.layout')


@section('content')

<div class="container">

<h2>Sửa lịch khởi hành</h2>

<form action="{{ route('admin.trips.update',$trip->id) }}" method="POST">

@csrf
@method('PUT')

<select name="tour_id" class="form-control mb-3">

@foreach($tours as $tour)

<option value="{{ $tour->id }}"
@if($trip->tour_id == $tour->id) selected @endif>

{{ $tour->name }}

</option>

@endforeach

</select>


<input type="date" name="start_date"
value="{{ $trip->start_date }}"
class="form-control mb-3">


<input type="date" name="end_date"
value="{{ $trip->end_date }}"
class="form-control mb-3">


<input type="number" name="max_people"
value="{{ $trip->max_people }}"
class="form-control mb-3">


<select name="status" class="form-control mb-3">

<option value="open" @if($trip->status=='open') selected @endif>
Mở
</option>

<option value="closed" @if($trip->status=='closed') selected @endif>
Đóng
</option>

</select>

<button class="btn btn-primary">Cập nhật</button>

</form>

</div>

@endsection