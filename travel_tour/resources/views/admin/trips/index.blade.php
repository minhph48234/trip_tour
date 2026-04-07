@extends('admin.layouts.layout')

@section('content_title','Danh sách lịch khởi hành')

@section('content')

<div class="container">

<h2>Quản lý lịch khởi hành</h2>

<a href="{{ route('admin.trips.create') }}" class="btn btn-primary mb-3">
    Thêm lịch khởi hành
</a>

{{-- ================= SEARCH DATE ================= --}}
<form method="GET" action="{{ route('admin.trips.index') }}" class="mb-3">

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <input type="date"
               name="start_date"
               value="{{ request('start_date') }}"
               class="form-control"
               placeholder="Ngày khởi hành">

        <input type="date"
               name="end_date"
               value="{{ request('end_date') }}"
               class="form-control"
               placeholder="Ngày kết thúc">

        <button type="submit" class="btn btn-primary">
            Lọc
        </button>

        <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">
            Reset
        </a>

    </div>

</form>

<table class="table table-bordered">
<thead>
<tr>
    <th>ID</th>
    <th>Tour</th>
    <th>Ngày khởi hành</th>
    <th>Ngày kết thúc</th>
    <th>Số chỗ</th>
    <th>Đã đặt</th>
    <th>Trạng thái</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($trips as $trip)

<tr>
<td>{{ $trip->id }}</td>

<td>{{ $trip->tour->name }}</td>

<td>{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}</td>

<td>{{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}</td>

<td>{{ $trip->max_people }}</td>

<td>{{ $trip->current_people }}</td>

<td>
    @php
        $statusText = match($trip->status){
            'open' => 'Đang mở',
            'full' => 'Đã đầy',
            'closed' => 'Đã đóng',
            default => $trip->status
        };

        $statusColor = match($trip->status){
            'open' => 'color:green; font-weight:bold',
            'full' => 'color:orange; font-weight:bold',
            'closed' => 'color:red; font-weight:bold',
            default => ''
        };
    @endphp

    <span style="{{ $statusColor }}">
        {{ $statusText }}
    </span>
</td>

<td>

<a href="{{ route('admin.trips.show',$trip->id) }}" class="btn btn-info btn-sm">Xem</a>

<a href="{{ route('admin.trips.edit',$trip->id) }}" class="btn btn-warning btn-sm">Sửa</a>

<form action="{{ route('admin.trips.destroy',$trip->id) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">Xóa</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $trips->links() }}

</div>

@endsection