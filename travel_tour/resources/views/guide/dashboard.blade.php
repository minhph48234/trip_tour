@extends('guide.layouts.layout')

@section('title','Dashboard')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark">Dashboard hướng dẫn viên</h4>
    <p class="text-muted small">
        Chào mừng <b>{{ auth()->user()->name }}</b>, đây là công việc của bạn hôm nay.
    </p>
</div>

{{-- CARD THỐNG KÊ --}}
<div class="row g-4">

    {{-- TỔNG TOUR --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-primary border-4">
            <h6 class="text-muted">TỔNG TOUR</h6>
            <h3 class="fw-bold">{{ $totalTours }}</h3>
        </div>
    </div>

    {{-- TOUR ĐANG DIỄN RA --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-success border-4">
            <h6 class="text-muted">ĐANG DIỄN RA</h6>
            <h3 class="fw-bold">{{ $ongoingTours }}</h3>
        </div>
    </div>

    {{-- KHÁCH --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-warning border-4">
            <h6 class="text-muted">TỔNG KHÁCH</h6>
            <h3 class="fw-bold">{{ $totalCustomers }}</h3>
        </div>
    </div>

    {{-- TOUR HÔM NAY --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 rounded-4 p-3 border-start border-info border-4">
            <h6 class="text-muted">TOUR HÔM NAY</h6>
            <h3 class="fw-bold">{{ $todayTours->count() }}</h3>
        </div>
    </div>

</div>

{{-- TOUR HÔM NAY --}}
<div class="card shadow-sm border-0 rounded-4 mt-4">
    <div class="card-header bg-white fw-bold">
        📅 Tour hôm nay
    </div>

    <div class="card-body">
        @forelse($todayTours as $group)
            <div class="mb-3 border-bottom pb-2">
                <h6 class="fw-bold text-primary">
                    {{ $group->trip->tour->name ?? 'Không có tên tour' }}
                </h6>

                <p class="mb-1">
                    🕒 Ngày đi: {{ $group->trip->start_date }}
                </p>

                <p class="mb-1">
                    👥 Số khách: {{ $group->current_people }}/{{ $group->max_people }}
                </p>

                <a href="{{ route('guide.groups.detail',$group->id) }}" 
                   class="btn btn-sm btn-primary">
                    Xem chi tiết
                </a>
            </div>
        @empty
            <p class="text-muted">Không có tour hôm nay</p>
        @endforelse
    </div>
</div>

{{-- DANH SÁCH ĐOÀN --}}
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
                    <th>Khách</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestGroups as $group)
                <tr>
                    <td>
                        {{ $group->trip->tour->name ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $group->trip->start_date ?? '' }}
                    </td>

                    <td>
                        {{ $group->current_people }}/{{ $group->max_people }}
                    </td>

                    <td>
                        <span class="badge 
                            {{ $group->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $group->status }}
                        </span>
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
                    <td colspan="5" class="text-center text-muted">
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