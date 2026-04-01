@extends('guide.layouts.layout')

@section('title','Tour được phân công')

@section('content')

<table class="table table-bordered">

<thead>

<tr>
<th>ID</th>
<th>Tour</th>
<th>Trip</th>
<th>Số khách</th>
<th>Hành động</th>
</tr>

</thead>

<tbody>

@foreach($groups as $group)

<tr>

<td>{{ $group->id }}</td>

<td>{{ $group->trip->tour->name ?? '' }}</td>

<td>{{ $group->trip_id }}</td>

<td>{{ $group->current_people }}</td>

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