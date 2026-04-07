@extends('guide.layouts.layout')

@section('title','Điểm danh khách')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">

        {{-- HEADER --}}
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">📋 Điểm danh khách trong đoàn</h4>
        </div>

        <div class="card-body">

            {{-- ALERT --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('guide.attendance.save',$group_id) }}">
                @csrf

                {{-- FORM GRID --}}
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Buổi</label>
                        <select name="session" class="form-select">
                            <option value="morning">🌅 Sáng</option>
                            <option value="afternoon">🌤 Chiều</option>
                            <option value="evening">🌙 Tối</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ngày</label>
                        <input type="date" 
                               name="attendance_date" 
                               class="form-control"
                               value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Ghi chú</label>
                        <input type="text" name="note" class="form-control" placeholder="Nhập ghi chú...">
                    </div>

                </div>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Khách</th>
                                <th class="text-center">Có mặt</th>
                                <th class="text-center">Vắng</th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($customers as $c)

                        <tr class="hover-row">

                            <td>
                                <div class="fw-semibold">{{ $c->name }}</div>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                       name="status[{{ $c->id }}]"
                                       value="present"
                                       class="form-check-input present-radio"
                                       checked>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                       name="status[{{ $c->id }}]"
                                       value="absent"
                                       class="form-check-input absent-radio">
                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- BUTTON --}}
                <div class="text-end mt-3">
                    <button class="btn btn-success px-4">
                        💾 Lưu điểm danh
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

{{-- CSS CUSTOM --}}
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

/* radio đẹp hơn */
.form-check-input {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* màu radio */
.present-radio:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.absent-radio:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}

/* table bo góc */
.table {
    border-radius: 12px;
    overflow: hidden;
}

/* button đẹp */
.btn-success {
    border-radius: 8px;
    font-weight: 500;
}

</style>

@endsection