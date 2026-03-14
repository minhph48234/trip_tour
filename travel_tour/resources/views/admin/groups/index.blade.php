@extends('admin.layouts.layout')

@section('content_title', 'Quản lý đoàn khởi hành')

@section('content')

<h2>Danh sách đoàn</h2>

<table border="1" class="table table-bordered table-hover align-middle">

<tr>

<th>ID</th>
<th>Tour</th>
<th>Ngày khởi hành</th>
<th>Số người</th>
<th>Guide</th>
<th>Action</th>

</tr>

@foreach($groups as $group)

<tr>

<td>{{ $group->id }}</td>

<td>{{ $group->trip->tour->name }}</td>

<td>{{ $group->trip->start_date }}</td>

<td>

{{ $group->current_people }}/{{ $group->max_people }}

</td>

<td>

{{ $group->guide->name ?? 'Chưa phân công' }}

</td>

<td>

<a href="{{ route('admin.groups.show',$group->id) }}">
Chi tiết
</a>

</td>

</tr>

@endforeach

</table>

{{ $groups->links() }}

@endsection