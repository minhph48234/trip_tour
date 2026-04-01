@extends('guide.layouts.layout')

@section('title','Điểm danh khách')

@section('content')

<div class="container mt-4">

<h3 class="mb-4">Điểm danh khách trong đoàn</h3>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('guide.attendance.save',$group_id) }}">

@csrf

<div class="mb-3">

<label class="form-label">Buổi điểm danh</label>

<select name="session" class="form-control" required>
    <option value="morning">Sáng</option>
    <option value="afternoon">Chiều</option>
    <option value="evening">Tối</option>
</select>

</div>

{{-- ✅ THÊM NGÀY --}}
<div class="mb-3">

<label class="form-label">Ngày điểm danh</label>

<input type="date" 
       name="attendance_date" 
       class="form-control"
       value="{{ date('Y-m-d') }}"
       required>

</div>


<div class="mb-3">

<label class="form-label">Ghi chú chung</label>

<input type="text" name="note" class="form-control">

</div>


<table class="table table-bordered">

<thead class="table-dark">

<tr>
<th>Khách</th>
<th>Có mặt</th>
<th>Vắng</th>
</tr>

</thead>

<tbody>

@foreach($customers as $c)

<tr>

<td>
<strong>{{ $c->name }}</strong>
</td>

<td class="text-center">

<input type="radio"
name="status[{{ $c->id }}]"
value="present"
checked>

</td>

<td class="text-center">

<input type="radio"
name="status[{{ $c->id }}]"
value="absent">

</td>

</tr>

@endforeach

</tbody>

</table>


<button class="btn btn-success">
Lưu điểm danh
</button>

</form>

</div>

@endsection