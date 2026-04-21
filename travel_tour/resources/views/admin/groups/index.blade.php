@extends('admin.layouts.layout')

@section('content_title','Quản lý đoàn du lịch')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách đoàn</h5>
    </div>

    <div class="card-body">

        {{-- ================= SEARCH + FILTER ================= --}}
        <form method="GET" class="row mb-4">

            <div class="col-md-3">
                <input type="text" name="keyword"
                       value="{{ request('keyword') }}"
                       class="form-control"
                       placeholder="Tìm theo tên tour...">
            </div>

            <div class="col-md-2">
                <input type="date" name="start_date"
                       value="{{ request('start_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <select name="filter" class="form-control">
                    <option value="">-- Bộ lọc nâng cao --</option>

                    <option value="lack" {{ request('filter') == 'lack' ? 'selected' : '' }}>
                        ⚠ Thiếu khách
                    </option>

                    <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>
                        ⏳ Chưa đủ khách
                    </option>

                    <option value="transfer" {{ request('filter') == 'transfer' ? 'selected' : '' }}>
                        🔥 Đang chuyển nhượng
                    </option>

                    <option value="coming" {{ request('filter') == 'coming' ? 'selected' : '' }}>
                        🚀 Sắp khởi hành (≤ 3 ngày)
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary">
                    Tìm kiếm
                </button>

                <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>

        </form>

        {{-- ================= TABLE ================= --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tour</th>
                        <th>Ngày đi</th>
                        <th>Ngày về</th>
                        <th>Số khách</th>
                        <th>Trạng thái</th>
                        <th>Chuyển nhượng</th>
                        <th>Tiến trình</th>
                        <th>Hướng dẫn viên</th>
                        <th>Xác nhận HDV</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($groups as $group)

                @php
                    $daysLeft = \Carbon\Carbon::today()->diffInDays($group->trip->start_date, false);
                @endphp

                <tr>

                    <td class="text-center">{{ $group->id }}</td>

                    <td>
                        <strong>{{ $group->trip->tour->name ?? 'N/A' }}</strong>
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($group->trip->start_date)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($group->trip->end_date)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        <span class="badge bg-info">
                            {{ $group->current_people }}/{{ $group->max_people }}
                        </span>
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if($group->status == 'pending')
                            <span class="badge bg-warning text-dark">Chờ đủ khách</span>
                        @elseif($group->status == 'confirmed')
                            <span class="badge bg-success">Đã xác nhận</span>
                        @elseif($group->status == 'full')
                            <span class="badge bg-primary">Đã đầy</span>
                        @elseif($group->status == 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                        @endif
                    </td>

                    {{-- CHUYỂN NHƯỢNG --}}
                    <td class="text-center">
                        @if($group->transfer_status == 'for_transfer')
                            <span class="badge bg-danger">🔥 Chuyển nhượng</span>
                        @else
                            <span class="badge bg-success">Bình thường</span>
                        @endif
                    </td>

                    {{-- PROGRESS --}}
                    <td class="text-center">
                        @if($group->progress == 'pending')
                            <span class="badge bg-secondary">Chưa khởi hành</span>
                        @elseif($group->progress == 'ongoing')
                            <span class="badge bg-info text-dark">Đang diễn ra</span>
                        @elseif($group->progress == 'completed')
                            <span class="badge bg-dark">Đã hoàn thành</span>
                        @endif
                    </td>

                    {{-- GUIDE (CHỈ HIỂN THỊ NẾU ACCEPTED) --}}
                    <td class="text-center">

                        @if($group->guide && $group->guide_confirm == 'accepted')
                            <span class="badge bg-success">
                                {{ $group->guide->name }}
                            </span>

                        @elseif($group->guide && $group->guide_confirm == 'pending')
                            <span class="text-muted">⏳ Chờ xác nhận</span>

                        @elseif($group->guide && $group->guide_confirm == 'rejected')
                            <span class="text-danger">❌ Từ chối</span>

                        @else
                            <span class="text-muted">Chưa phân công</span>
                        @endif

                    </td>

                    {{-- XÁC NHẬN HDV --}}
                    <td class="text-center">

                        @if($group->guide_confirm == 'pending')
                            <span class="badge bg-warning text-dark">⏳ Chờ</span>

                        @elseif($group->guide_confirm == 'accepted')
                            <span class="badge bg-success">Đã đồng ý</span>

                        @elseif($group->guide_confirm == 'rejected')
                            <span class="badge bg-danger">Từ chối</span>

                        @else
                            <span class="text-muted">--</span>
                        @endif

                    </td>

                    {{-- ACTION --}}
                    <td class="text-center">
                        <a href="{{ route('admin.groups.show',$group->id) }}"
                           class="btn btn-info btn-sm">
                            Xem
                        </a>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $groups->appends(request()->query())->links() }}
        </div>

    </div>
</div>

@endsection