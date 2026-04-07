@extends('guide.layouts.layout')

@section('title','Dashboard')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark">📊 Dashboard hướng dẫn viên</h4>
    <p class="text-muted small">
        Chào mừng <b>{{ auth()->user()->name }}</b>
    </p>
</div>

{{-- CARD THỐNG KÊ --}}
<div class="row g-4">

    <div class="col-md-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-primary">
                    <i class="bi bi-map"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">TỔNG TOUR</h6>
                    <h3 class="fw-bold mb-0">{{ $totalTours }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-success">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">TUẦN NÀY</h6>
                    <h3 class="fw-bold mb-0">{{ $weeklyTours }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card border-0 shadow">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-info">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">THÁNG NÀY</h6>
                    <h3 class="fw-bold mb-0">{{ $monthlyTours }}</h3>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- DANH SÁCH TOUR --}}
<div class="card shadow border-0 rounded-4 mt-4">

    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>📋 Tour được phân công</span>

        <a href="{{ route('guide.groups') }}" class="btn btn-primary btn-sm px-3">
            Xem tất cả
        </a>
    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
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

                <tr class="hover-row">

                    <td class="fw-semibold">
                        {{ $group->trip->tour->name ?? 'N/A' }}
                    </td>

                    <td>
                        <span class="text-muted">
                            {{ $group->trip->start_date ?? '' }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted">
                            {{ $group->trip->end_date ?? '' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $group->current_people }}/{{ $group->max_people }}
                        </span>
                    </td>

                    <td>
                        @if($group->progress == 'pending')
                            <span class="badge status-badge bg-warning">Chưa hoàn thành</span>
                        @elseif($group->progress == 'ongoing')
                            <span class="badge status-badge bg-primary">Đang diễn ra</span>
                        @else
                            <span class="badge status-badge bg-success">Hoàn thành</span>
                        @endif
                    </td>

                    <td class="text-end">

                        <a href="{{ route('guide.groups.detail',$group->id) }}" 
                           class="btn btn-sm btn-outline-primary me-1">
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
                    <td colspan="6" class="text-center text-muted py-4">
                        Chưa có tour nào
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- CSS --}}
<style>

/* CARD */
.stat-card {
    border-radius: 16px;
    transition: 0.3s;
}
.stat-card:hover {
    transform: translateY(-4px);
}

/* ICON */
.icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

/* TABLE */
.hover-row:hover {
    background-color: #f8f9fa;
}

/* BADGE */
.status-badge {
    padding: 6px 10px;
    font-size: 12px;
    border-radius: 8px;
}

/* BUTTON */
.btn {
    border-radius: 8px;
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
}

</style>

@endsection