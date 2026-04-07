@extends('admin.layouts.layout')

@section('title', 'Bảng điều khiển')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark">Tổng quan hệ thống</h4>
    <p class="text-muted small">Chào mừng bạn trở lại, đây là những gì đang diễn ra hôm nay.</p>
</div>

{{-- CẢNH BÁO NHANH --}}
<div class="alert alert-warning d-flex justify-content-between flex-wrap gap-3">
    <div>⚠️ Đơn chưa xử lý: <strong>{{ $pendingBookings }}</strong></div>
    <div>📅 Trip sắp khởi hành (1–3 ngày): <strong>{{ $upcomingTrips }}</strong></div>
    <div>🔥 Trip sắp full: <strong>{{ $almostFullTrips }}</strong></div>
</div>

{{-- THỐNG KÊ CHÍNH --}}
<div class="row g-4">

    {{-- TOUR --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-primary border-4 p-3">
            <p class="text-muted small mb-1">TỔNG TOUR</p>
            <h4>{{ $tourCount }}</h4>
        </div>
    </div>

    {{-- BOOKING --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-success border-4 p-3">
            <p class="text-muted small mb-1">BOOKING</p>
            <h4>{{ $bookingCount }}</h4>
        </div>
    </div>

    {{-- USER --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-info border-4 p-3">
            <p class="text-muted small mb-1">NGƯỜI DÙNG</p>
            <h4>{{ $userCount }}</h4>
        </div>
    </div>

    {{-- DOANH THU --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-warning border-4 p-3">
            <p class="text-muted small mb-1">TỔNG DOANH THU</p>
            <h5>{{ number_format($revenue) }} đ</h5>
        </div>
    </div>

</div>


{{-- DOANH THU CHI TIẾT --}}
<div class="row g-4 mt-2">

    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <p class="text-muted mb-1">Doanh thu hôm nay</p>
            <h5 class="text-success">
                {{ number_format($revenueToday) }} đ
            </h5>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <p class="text-muted mb-1">Doanh thu tháng</p>
            <h5 class="text-warning">
                {{ number_format($revenueMonth) }} đ
            </h5>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <p class="text-muted mb-1">Doanh thu năm</p>
            <h5 class="text-primary">
                {{ number_format($revenueYear) }} đ
            </h5>
        </div>
    </div>

</div>


{{-- BOOKING --}}
<div class="alert alert-danger mt-4">
    ❗ Booking chưa thanh toán FULL: 
    <strong>{{ $pendingFullBookings }}</strong>
</div>


{{-- TOP TOUR --}}
<div class="row mt-4">

    {{-- TOP BOOKING --}}
    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>🔥 Top 5 tour nhiều booking</h5>

            <ul class="list-group mt-3">
                @forelse($topToursByBooking as $tour)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $tour->name }}
                        <span class="badge bg-primary">
                            {{ $tour->bookings_count }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-center">
                        Không có dữ liệu
                    </li>
                @endforelse
            </ul>

        </div>
    </div>

    {{-- TOP DOANH THU --}}
    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h5>💰 Top 5 tour doanh thu cao</h5>

            <ul class="list-group mt-3">
                @forelse($topToursByRevenue as $tour)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $tour->name }}
                        <span class="badge bg-success">
                            {{ number_format($tour->total_revenue) }} đ
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-center">
                        Không có dữ liệu
                    </li>
                @endforelse
            </ul>

        </div>
    </div>

</div>


{{-- STYLE --}}
<style>
.card {
    border-radius: 12px;
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.border-start {
    border-left-width: 5px !important;
}
</style>

@endsection