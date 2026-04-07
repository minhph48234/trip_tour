@extends('admin.layouts.layout')

@section('title','Chi tiết thanh toán')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">
            <i class="fa fa-credit-card me-2 text-primary"></i>
            Chi tiết thanh toán
        </h4>

        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">

        {{-- KHÁCH --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    Khách hàng
                </div>
                <div class="card-body">
                    <p><b>Tên:</b> {{ $payment->booking->customer_name }}</p>
                    <p><b>Email:</b> {{ $payment->booking->customer_email ?? '---' }}</p>
                    <p><b>SĐT:</b> {{ $payment->booking->customer_phone }}</p>
                </div>
            </div>
        </div>

        {{-- TOUR --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    Tour
                </div>
                <div class="card-body">
                    <p><b>Tên tour:</b> {{ $payment->booking->tour->name }}</p>
                    <p><b>Ngày đi:</b>
                        {{ \Carbon\Carbon::parse($payment->booking->trip->start_date)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="col-12">
            <div class="card shadow-lg border-0">

                <div class="card-header bg-dark text-white">
                    Thông tin thanh toán
                </div>

                <div class="card-body row">

                    <div class="col-md-6">

                        <p><b>Số tiền:</b>
                            <span class="text-danger fw-bold fs-5">
                                {{ number_format($payment->amount) }} VNĐ
                            </span>
                        </p>

                        <p><b>Loại:</b>
                            <span class="badge bg-primary">
                                {{ $payment->type_text }}
                            </span>
                        </p>

                        <p><b>Phương thức:</b>
                            <span class="badge bg-secondary">
                                {{ strtoupper($payment->method) }}
                            </span>
                        </p>

                    </div>

                    <div class="col-md-6">

                        {{-- STATUS PAYMENT --}}
                        <p><b>Thanh toán:</b>
                            @if($payment->status == 'paid')
                                <span class="badge bg-success">Đã thanh toán</span>
                            @elseif($payment->status == 'pending')
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            @else
                                <span class="badge bg-danger">Thất bại</span>
                            @endif
                        </p>

                        {{-- 🔥 STATUS ADMIN --}}
                        <p><b>Xác nhận admin:</b>
                            @if($payment->admin_confirm_status == 'confirmed')
                                <span class="badge bg-success">✔ Đã xác nhận</span>
                            @else
                                <span class="badge bg-warning text-dark">⏳ Chờ xác nhận</span>
                            @endif
                        </p>

                        <p><b>Mã giao dịch:</b>
                            {{ $payment->transaction_code ?? '---' }}
                        </p>

                        <p><b>Thời gian:</b>
                            {{ optional($payment->paid_at)->format('d/m/Y H:i') ?? '---' }}
                        </p>

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="card-footer bg-white">

                    @if(
                        $payment->status == 'paid'
                        && $payment->admin_confirm_status != 'confirmed'
                    )
                        <form action="{{ route('admin.payments.confirm',$payment->id) }}" method="POST">
                            @csrf
                            <button onclick="return confirm('Xác nhận thanh toán này?')"
                                class="btn btn-success">
                                <i class="fa fa-check me-1"></i>
                                Xác nhận thanh toán
                            </button>
                        </form>
                    @else
                        <span class="text-success fw-bold">
                            ✔ Đã xác nhận hoặc không hợp lệ
                        </span>
                    @endif

                </div>

            </div>
        </div>

    </div>

</div>

@endsection