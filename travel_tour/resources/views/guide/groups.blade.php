@extends('guide.layouts.layout')

@section('title','Tour được phân công')

@section('content')

<div class="container mt-4">

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow border-0 rounded-4">

        {{-- HEADER --}}
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📋 Tour được phân công</h5>
            <span class="badge bg-light text-dark">
                {{ count($groups) }} tour
            </span>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>Khách</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($groups as $group)

                    <tr class="hover-row">

                        <td>{{ $group->id }}</td>

                        <td class="fw-semibold">
                            {{ $group->trip->tour->name ?? '' }}
                        </td>

                        <td>
                            <span class="text-muted">
                                {{ $group->trip->start_date }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted">
                                {{ $group->trip->end_date }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                {{ $group->current_people }}/{{ $group->max_people }}
                            </span>
                        </td>

                        {{-- STATUS --}}
                        <td>

                            <form action="{{ route('guide.groups.progress',$group->id) }}" method="POST">
                                @csrf

                                <select name="progress" onchange="this.form.submit()" class="form-select status-select">

                                    <option value="pending" {{ $group->progress == 'pending' ? 'selected' : '' }}>
                                        ⏳ Chưa hoàn thành
                                    </option>

                                    <option value="ongoing" {{ $group->progress == 'ongoing' ? 'selected' : '' }}>
                                        🚀 Đang diễn ra
                                    </option>

                                    <option value="completed" {{ $group->progress == 'completed' ? 'selected' : '' }}>
                                        ✅ Hoàn thành
                                    </option>

                                </select>

                            </form>

                        </td>

                        {{-- ACTION --}}
                        <td class="text-end">

                            <a href="{{ route('guide.customers',$group->id) }}"
                               class="btn btn-sm btn-outline-info me-1">
                                👥 Khách
                            </a>

                            <a href="{{ route('guide.attendance',$group->id) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                ✔ Điểm danh
                            </a>

                            <a href="{{ route('guide.groups.detail', $group->id) }}"
                               class="btn btn-sm btn-outline-success">
                                🔍 Chi tiết
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Không có tour nào
                        </td>
                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

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

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* HOVER */
.hover-row:hover {
    background-color: #f8f9fa;
}

/* BADGE */
.badge {
    padding: 6px 10px;
    font-size: 12px;
    border-radius: 8px;
}

/* SELECT STATUS */
.status-select {
    border-radius: 8px;
    font-size: 14px;
    padding: 4px 8px;
    border: 1px solid #dee2e6;
    transition: 0.2s;
}

.status-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13,110,253,0.3);
}

/* BUTTON */
.btn {
    border-radius: 8px;
    font-size: 13px;
}

/* HEADER */
.card-header {
    font-size: 16px;
}

</style>

@endsection