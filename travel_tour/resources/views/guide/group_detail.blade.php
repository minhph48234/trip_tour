@extends('guide.layouts.layout')

@section('title','Chi tiết tour')

@section('content')

<div class="container mt-4">

    <h4 class="fw-bold mb-4">📋 Chi tiết đoàn du lịch</h4>

    {{-- THÔNG TIN --}}
    <div class="card shadow border-0 rounded-4 mb-4">

        <div class="card-header bg-primary text-white rounded-top-4">
            Thông tin đoàn
        </div>

        <div class="card-body">

            <div class="row g-3">

                {{-- LEFT --}}
                <div class="col-md-6">

                    <div class="info-item">
                        <span>Tour</span>
                        <strong>{{ optional(optional($group->trip)->tour)->name ?? '---' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Điểm đi</span>
                        <strong>{{ optional(optional($group->trip)->tour)->departure_location ?? '' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Điểm đến</span>
                        <strong>{{ optional(optional($group->trip)->tour)->destination ?? '' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Thời gian</span>
                        <strong>{{ optional(optional($group->trip)->tour)->duration ?? '' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Mã đoàn</span>
                        <strong>#{{ $group->id }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Loại đoàn</span>
                        <strong class="badge bg-light text-dark">
                            {{ $group->type ?? '' }}
                        </strong>
                    </div>

                    <div class="info-item">
                        <span>Hướng dẫn viên</span>
                        <strong>{{ $group->guide->name ?? 'Chưa phân công' }}</strong>
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-md-6">

                    <div class="info-item">
                        <span>Ngày đi</span>
                        <strong>{{ optional($group->trip)->start_date }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Ngày kết thúc</span>
                        <strong>{{ optional($group->trip)->end_date }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Số người</span>
                        <strong class="badge bg-light text-dark">
                            {{ $group->current_people ?? 0 }}/{{ $group->max_people ?? 0 }}
                        </strong>
                    </div>

                    <div class="info-item">
                        <span>Trạng thái</span>

                        @if($group->progress == 'pending')
                            <span class="badge status-pending">Chưa hoàn thành</span>
                        @elseif($group->progress == 'ongoing')
                            <span class="badge status-running">Đang diễn ra</span>
                        @else
                            <span class="badge status-done">Hoàn thành</span>
                        @endif
                    </div>

                    <div class="info-item">
                        <span>Ghi chú</span>
                        <strong>{{ $group->note ?? 'Không có' }}</strong>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- BUTTON --}}
    <div class="mb-4 d-flex gap-2">

        <a href="{{ route('guide.customers', $group->id) }}" 
           class="btn btn-outline-primary">
            👥 Danh sách khách
        </a>

        <a href="{{ route('guide.attendance', $group->id) }}" 
           class="btn btn-outline-success">
            ✅ Điểm danh
        </a>

    </div>


    {{-- DANH SÁCH KHÁCH --}}
    <div class="card shadow border-0 rounded-4">

        <div class="card-header bg-dark text-white rounded-top-4">
            👥 Danh sách khách trong đoàn
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tên khách</th>
                        <th>Email</th>
                        <th>SĐT</th>
                    </tr>
                </thead>

                <tbody>

                    @php $stt = 1; @endphp

                    @forelse($group->bookings as $booking)
                        @foreach($booking->customers ?? [] as $customer)

                        <tr class="hover-row">

                            <td>{{ $stt++ }}</td>

                            <td class="fw-semibold">
                                {{ $customer->name }}
                            </td>

                            <td class="text-muted">
                                {{ $customer->email ?? '' }}
                            </td>

                            <td>
                                {{ $customer->phone ?? '' }}
                            </td>

                        </tr>

                        @endforeach
                    @empty

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Không có khách
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- CSS --}}
<style>

/* CARD */
.card {
    border-radius: 16px;
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-3px);
}

/* INFO ITEM */
.info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #eee;
}
.info-item span {
    color: #888;
}
.info-item strong {
    font-weight: 600;
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* HOVER */
.hover-row:hover {
    background-color: #f8f9fa;
}

/* STATUS */
.status-pending {
    background: #fff3cd;
    color: #856404;
    padding: 5px 10px;
    border-radius: 8px;
}

.status-running {
    background: #cfe2ff;
    color: #084298;
    padding: 5px 10px;
    border-radius: 8px;
}

.status-done {
    background: #e6f9f0;
    color: #198754;
    padding: 5px 10px;
    border-radius: 8px;
}

/* BUTTON */
.btn {
    border-radius: 8px;
}

</style>

@endsection