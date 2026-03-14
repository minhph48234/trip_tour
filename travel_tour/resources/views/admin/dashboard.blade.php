<!-- <h1>Admin Dashboard</h1>

<form method="POST" action="/logout">
@csrf
<button>Logout</button>
</form> -->

@extends('admin.layouts.layout')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark">Tổng quan hệ thống</h4>
    <p class="text-muted small">Chào mừng bạn trở lại, đây là những gì đang diễn ra hôm nay.</p>
</div>

<div class="row g-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-sm text-muted uppercase fw-bold mb-1" style="font-size: 0.75rem;">TỔNG TOURS</p>
                    <h3 class="fw-bold mb-0">24</h3>
                </div>
                <div class="p-3 bg-primary-subtle text-primary rounded-4">
                    <i class="fas fa-map-marked-alt fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-sm text-muted uppercase fw-bold mb-1" style="font-size: 0.75rem;">ĐƠN ĐẶT MỚI</p>
                    <h3 class="fw-bold mb-0">156</h3>
                </div>
                <div class="p-3 bg-success-subtle text-success rounded-4">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-sm text-muted uppercase fw-bold mb-1" style="font-size: 0.75rem;">DOANH THU</p>
                    <h3 class="fw-bold mb-0">1.2 tỷ</h3>
                </div>
                <div class="p-3 bg-warning-subtle text-warning rounded-4">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-purple border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-sm text-muted uppercase fw-bold mb-1" style="font-size: 0.75rem;">NGƯỜI DÙNG</p>
                    <h3 class="fw-bold mb-0">850</h3>
                </div>
                <div class="p-3 bg-purple-subtle text-purple rounded-4">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mt-5 overflow-hidden">
    <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2 text-primary"></i>Tours mới cập nhật</h5>
        <a href="" class="nav-link-admin btn btn-primary btn-sm px-4 rounded-pill shadow-sm border-0">
            <i class="fas fa-plus me-1"></i> Thêm tour mới
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    <th class="ps-4 py-3 text-secondary uppercase border-0">TÊN TOUR</th>
                    <th class="py-3 text-secondary uppercase border-0">GIÁ NIÊM YẾT</th>
                    <th class="py-3 text-secondary uppercase border-0 text-center">TRẠNG THÁI</th>
                    <th class="pe-4 py-3 text-secondary uppercase border-0 text-end">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody class="border-top-0" style="font-size: 0.9rem;">
                <tr>
                    <td class="ps-4">
                        <span class="fw-bold text-dark">Phú Quốc 3 ngày 2 đêm</span>
                    </td>
                    <td>
                        <span class="text-primary fw-bold">3,500,000đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-normal">
                            Đang chạy
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="#" class="btn btn-sm btn-outline-warning border-0 rounded-circle"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-outline-danger border-0 rounded-circle"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e0f2fe !important; }
    .bg-success-subtle { background-color: #dcfce7 !important; }
    .bg-warning-subtle { background-color: #fef3c7 !important; }
    .bg-purple-subtle { background-color: #f3e8ff !important; }
    .text-purple { color: #a855f7 !important; }
    .border-purple { border-color: #a855f7 !important; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
</style>
@endsection