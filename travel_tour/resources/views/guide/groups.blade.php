@extends('guide.layouts.layout')

@section('title','Tour được phân công')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<thead>
<tr>
    <th>ID</th>
    <th>Tour</th>
    <th>Ngày đi</th>
    <th>Ngày về</th>
    <th>Số khách</th>
    <th>Trạng thái</th>
    <th>Hành động</th>
</tr>
</thead>

<tbody>

@foreach($groups as $group)

<tr>
<td>{{ $group->id }}</td>

<td>{{ $group->trip->tour->name ?? '' }}</td>

<td>{{ $group->trip->start_date }}</td>

<td>{{ $group->trip->end_date }}</td>

<td>{{ $group->current_people }}</td>

<td>
<form action="{{ route('guide.groups.progress',$group->id) }}" method="POST">
    @csrf

    <select name="progress" onchange="this.form.submit()" class="form-control">

        <option value="pending" {{ $group->progress == 'pending' ? 'selected' : '' }}>
            Chưa hoàn thành
        </option>

        <option value="ongoing" {{ $group->progress == 'ongoing' ? 'selected' : '' }}>
            Đang diễn ra
        </option>

        <option value="completed" {{ $group->progress == 'completed' ? 'selected' : '' }}>
            Hoàn thành
        </option>

    </select>
</form>
</td>

<td>
<a href="{{ route('guide.customers',$group->id) }}"
class="btn btn-sm btn-info">
Danh sách khách
</a>

<a href="{{ route('guide.attendance',$group->id) }}"
class="btn btn-primary">
Điểm danh
</a>

<a href="{{ route('guide.groups.detail', $group->id) }}"
class="btn btn-sm btn-success">
Chi tiết tour
</a>
</td>

</tr>

@endforeach

</tbody>

</table>

@endsection