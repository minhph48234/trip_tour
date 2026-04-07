@extends('guide.layouts.layout')

@section('title','Lịch sử tour')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0 rounded-4">

        {{-- HEADER --}}
        <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📚 Lịch sử tour đã dẫn</h5>

            <span class="badge bg-light text-dark">
                {{ $groups->count() }} tour
            </span>
        </div>

        <div class="card-body">

            @if($groups->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên tour</th>
                            <th>Ngày đi</th>
                            <th>Ngày về</th>
                            <th>Khách</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($groups as $index => $group)

                        <tr class="hover-row">

                            <td>{{ $index + 1 }}</td>

                            <td class="fw-semibold text-start">
                                {{ $group->trip->tour->name ?? '---' }}
                            </td>

                            <td>
                                <span class="text-muted">
                                    {{ $group->trip->start_date ?? '---' }}
                                </span>
                            </td>

                            <td>
                                <span class="text-muted">
                                    {{ $group->trip->end_date ?? '---' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $group->current_people }} / {{ $group->max_people }}
                                </span>
                            </td>

                            <td>
                                <span class="badge status-done">
                                    ✔ Hoàn thành
                                </span>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Chưa có tour nào đã hoàn thành</p>
            </div>

            @endif

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

/* HOVER ROW */
.hover-row:hover {
    background-color: #f8f9fa;
}

/* BADGE */
.status-done {
    background: #e6f9f0;
    color: #16a34a;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
}

/* HEADER */
.card-header {
    font-size: 16px;
}

/* EMPTY ICON */
.bi-inbox {
    color: #ccc;
}

/* TEXT */
.text-muted {
    font-size: 14px;
}

</style>

@endsection