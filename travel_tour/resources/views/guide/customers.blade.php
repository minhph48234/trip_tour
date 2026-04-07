@extends('guide.layouts.layout')

@section('title','Danh sách khách')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        {{-- HEADER --}}
        <div class="card-header bg-dark text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">👥 Danh sách khách</h4>
            <span class="badge bg-light text-dark">
                {{ count($customers) }} khách
            </span>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Giới tính</th>
                            <th>Điện thoại</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($customers as $index => $c)
                        <tr class="hover-row">

                            <td>{{ $index + 1 }}</td>

                            <td>
                                <div class="fw-semibold">{{ $c->name }}</div>
                            </td>

                            <td>
                                @if($c->gender == 'male')
                                    <span class="badge bg-primary">Nam</span>
                                @elseif($c->gender == 'female')
                                    <span class="badge bg-danger">Nữ</span>
                                @else
                                    <span class="badge bg-secondary">Khác</span>
                                @endif
                            </td>

                            <td>
                                <span class="text-muted">{{ $c->phone }}</span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Không có khách nào
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

.card {
    transition: 0.3s;
}
.card:hover {
    transform: translateY(-2px);
}

/* hover row */
.hover-row:hover {
    background-color: #f8f9fa;
}

/* table bo góc */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* header table */
.table thead th {
    font-weight: 600;
}

/* badge */
.badge {
    padding: 6px 10px;
    font-size: 12px;
    border-radius: 8px;
}

</style>

@endsection