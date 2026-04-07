@extends('admin.layouts.layout')

@section('content_title','Quản lý thanh toán')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">
            Danh sách thanh toán
        </h4>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-3">
        <div class="row g-2">

            {{-- KEYWORD --}}
            <div class="col-md-4">
                <input type="text"
                       name="keyword"
                       value="{{ request('keyword') }}"
                       class="form-control"
                       placeholder="Tìm theo tên khách, tour...">
            </div>

            {{-- STATUS --}}
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Trạng thái thanh toán --</option>

                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>
                        Chờ xử lý
                    </option>

                    <option value="paid" {{ request('status')=='paid'?'selected':'' }}>
                        Đã thanh toán
                    </option>

                    <option value="failed" {{ request('status')=='failed'?'selected':'' }}>
                        Thất bại
                    </option>

                    <option value="refunded" {{ request('status')=='refunded'?'selected':'' }}>
                        Hoàn tiền
                    </option>
                </select>
            </div>

            {{-- METHOD --}}
            <div class="col-md-3">
                <select name="method" class="form-select">
                    <option value="">-- Phương thức --</option>

                    <option value="cash" {{ request('method')=='cash'?'selected':'' }}>
                        Tiền mặt
                    </option>

                    <option value="vnpay" {{ request('method')=='vnpay'?'selected':'' }}>
                        VNPAY
                    </option>

                    <option value="momo" {{ request('method')=='momo'?'selected':'' }}>
                        MOMO
                    </option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Tìm
                </button>

                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Khách</th>
                            <th>Tour</th>
                            <th>Số tiền</th>
                            <th>Loại</th>
                            <th>Phương thức</th>
                            <th>Thanh toán</th>
                            <th>Admin</th>
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $p)
                        <tr>

                            {{-- ID --}}
                            <td class="fw-semibold text-muted">
                                #{{ $p->id }}
                            </td>

                            {{-- KHÁCH --}}
                            <td>
                                {{ optional($p->booking)->customer_name ?? '---' }}
                            </td>

                            {{-- TOUR --}}
                            <td>
                                {{ optional(optional($p->booking)->tour)->name ?? '---' }}
                            </td>

                            {{-- AMOUNT --}}
                            <td class="text-danger fw-bold">
                                {{ number_format($p->amount) }} đ
                            </td>

                            {{-- TYPE --}}
                            <td>
                                @switch($p->type)
                                    @case('deposit')
                                        <span class="badge bg-info">Đặt cọc</span>
                                        @break
                                    @case('final')
                                        <span class="badge bg-primary">Thanh toán đủ</span>
                                        @break
                                    @case('extra')
                                        <span class="badge bg-secondary">Phụ phí</span>
                                        @break
                                @endswitch
                            </td>

                            {{-- METHOD --}}
                            <td>
                                <span class="fw-semibold">
                                    {{ strtoupper($p->method) }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @switch($p->status)
                                    @case('paid')
                                        <span class="badge bg-success">Đã thanh toán</span>
                                        @break

                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                        @break

                                    @case('failed')
                                        <span class="badge bg-danger">Thất bại</span>
                                        @break

                                    @case('refunded')
                                        <span class="badge bg-info text-dark">Hoàn tiền</span>
                                        @break

                                    @default
                                        <span class="badge bg-secondary">{{ $p->status }}</span>
                                @endswitch
                            </td>

                            {{-- ADMIN CONFIRM --}}
                            <td>
                                @if($p->admin_confirm_status == 'confirmed')
                                    <span class="badge bg-success">✔ Đã xác nhận</span>
                                @else
                                    <span class="badge bg-warning text-dark">⏳ Chờ xác nhận</span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td>

                                {{-- VIEW --}}
                                <a href="{{ route('admin.payments.show',$p->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>

                                {{-- CONFIRM --}}
                                @if(
                                    $p->status == 'paid'
                                    && $p->admin_confirm_status != 'confirmed'
                                )
                                <form action="{{ route('admin.payments.confirm',$p->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button onclick="return confirm('Xác nhận thanh toán?')"
                                            class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">
                                Không có dữ liệu thanh toán
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $payments->withQueryString()->links() }}
    </div>

</div>

@endsection