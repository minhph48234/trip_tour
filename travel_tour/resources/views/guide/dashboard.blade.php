@extends('guide.layouts.layout')

@section('title','Dashboard')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark">Dashboard hướng dẫn viên</h4>
    <p class="text-muted small">
        Chào mừng <b>{{ auth()->user()->name }}</b>
    </p>
</div>

{{-- CARD THỐNG KÊ --}}
<div class="row g-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-primary border-4">
            <h6 class="text-muted">TỔNG TOUR</h6>
            <h3 class="fw-bold">{{ $totalTours }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-success border-4">
            <h6 class="text-muted">TOUR TUẦN NÀY</h6>
            <h3 class="fw-bold">{{ $weeklyTours }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-info border-4">
            <h6 class="text-muted">TOUR THÁNG NÀY</h6>
            <h3 class="fw-bold">{{ $monthlyTours }}</h3>
        </div>
    </div>

</div>

{{-- DANH SÁCH TOUR --}}
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white fw-bold d-flex justify-content-between">
        <span>📋 Tour được phân công</span>

        <a href="{{ route('guide.groups') }}" class="btn btn-sm btn-primary">
            Xem tất cả
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Tên tour</th>
                    <th>Ngày đi</th>
                    <th>Ngày về</th>
                    <th>Khách</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($assignedTours as $group)
                <tr>
                    <td>{{ $group->trip->tour->name ?? 'N/A' }}</td>

                    <td>{{ $group->trip->start_date ?? '' }}</td>

                    <td>{{ $group->trip->end_date ?? '' }}</td>

                    <td>{{ $group->current_people }}/{{ $group->max_people }}</td>

                    <td>
                        @if($group->progress == 'pending')
                            <span class="badge bg-warning">Chưa hoàn thành</span>
                        @elseif($group->progress == 'ongoing')
                            <span class="badge bg-primary">Đang diễn ra</span>
                        @else
                            <span class="badge bg-success">Hoàn thành</span>
                        @endif
                    </td>

                    <td class="text-end">
                        <a href="{{ route('guide.groups.detail',$group->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            Xem
                        </a>

                        <a href="{{ route('guide.attendance',$group->id) }}" 
                           class="btn btn-sm btn-outline-success">
                            Điểm danh
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Chưa có tour nào
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

<style>
.card {
    transition: 0.2s;
}
.card:hover {
    transform: translateY(-3px);
}
</style>

@endsection