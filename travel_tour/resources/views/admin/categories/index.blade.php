@extends('admin.layouts.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 px-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Danh mục Tour</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="/admin" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Danh mục</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="nav-link-admin btn btn-primary rounded-pill px-4 shadow-sm d-flex align-items-center border-0" style="background: var(--primary-color); transition: 0.3s;">
        <i class="fas fa-plus-circle me-2"></i>
        <span>Thêm danh mục mới</span>
    </a>
</div>

<div class="container-fluid px-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="fas fa-layer-group me-2 text-primary"></i>Danh sách nhóm tour hiện có
            </h6>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr style="font-size: 0.75rem; letter-spacing: 1px;">
                        <th class="ps-4 py-3 text-secondary uppercase border-0">TÊN DANH MỤC</th>
                        <th class="py-3 text-secondary uppercase border-0">SLUG</th>
                        <th class="py-3 text-secondary uppercase border-0 text-center">TRẠNG THÁI</th>
                        <th class="pe-4 py-3 text-secondary uppercase border-0 text-end">HÀNH ĐỘNG</th>
                    </tr>
                </thead>
                <tbody class="border-top-0" style="font-size: 0.9rem;">
                    @foreach($categories as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle rounded-3 p-2 me-3 text-primary d-none d-md-block">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>
                            <code class="bg-light text-primary px-2 py-1 rounded small">/{{ $item->slug }}</code>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-normal" style="font-size: 0.75rem;">
                                <i class="fas fa-check-circle me-1"></i> Đang hoạt động
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $item->id) }}" class="nav-link-admin btn btn-sm btn-outline-primary border-0 rounded-circle" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Hiệu ứng hover cho dòng trong bảng */
    .table-hover tbody tr:hover {
        background-color: #f8fafc !important;
        transition: 0.2s;
    }
    /* Màu nền nhẹ cho icon danh mục */
    .bg-primary-subtle {
        background-color: #e0f2fe !important;
    }
    .bg-success-subtle {
        background-color: #dcfce7 !important;
    }
    /* Chỉnh lại độ bo góc cho table responsive wrapper */
    .table-responsive {
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }
</style>
@endsection