@extends('guide.layouts.layout')

@section('title','Danh sách khách')

@section('content')

<table class="table table-bordered">

<thead>

<tr>
<th>#</th>
<th>Tên</th>
<th>Giới tính</th>
<th>Điện thoại</th>
</tr>

</thead>

<tbody>

@foreach($customers as $c)

<tr>

<td>{{ $c->id }}</td>
<td>{{ $c->name }}</td>
<td>{{ $c->gender }}</td>
<td>{{ $c->phone }}</td>

</tr>

@endforeach

</tbody>

</table>

@endsection