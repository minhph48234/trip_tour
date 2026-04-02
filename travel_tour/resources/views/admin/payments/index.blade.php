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
                            <th>Admin</th> {{-- 🔥 thêm --}}
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $p)
                        <tr>

                            <td class="fw-semibold text-muted">
                                #{{ $p->id }}
                            </td>

                            <td class="fw-medium">
                                {{ $p->booking->customer_name }}
                            </td>

                            <td>
                                {{ $p->booking->tour->name ?? '---' }}
                            </td>

                            <td class="text-danger fw-bold">
                                {{ number_format($p->amount) }} đ
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $p->type_text }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-semibold">
                                    {{ strtoupper($p->method) }}
                                </span>
                            </td>

                            {{-- STATUS THANH TOÁN --}}
                            <td>
                                @if($p->status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($p->status == 'pending')
                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                @elseif($p->status == 'failed')
                                    <span class="badge bg-danger">Thất bại</span>
                                @else
                                    <span class="badge bg-secondary">{{ $p->status }}</span>
                                @endif
                            </td>

                            {{-- 🔥 STATUS ADMIN --}}
                            <td>
                                @if($p->admin_confirm_status == 'confirmed')
                                    <span class="badge bg-success">
                                        ✔ Đã xác nhận
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        ⏳ Chờ xác nhận
                                    </span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td>

                                <a href="{{ route('admin.payments.show',$p->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>

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

    <div class="mt-4">
        {{ $payments->links() }}
    </div>

</div>

@endsection