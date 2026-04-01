@extends('guide.layouts.layout')

@section('title','Chi tiết tour được phân công')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">📋 Chi tiết đoàn du lịch</h3>

    <!-- THÔNG TIN CHUNG -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row">

                <!-- LEFT -->
                <div class="col-md-6">
                    <p>
                        <strong>Tour:</strong> 
                        {{ optional(optional($group->trip)->tour)->name ?? 'Không có tour' }}
                    </p>

                    <p>
                        <strong>Điểm đi:</strong> 
                        {{ optional(optional($group->trip)->tour)->departure_location ?? '' }}
                    </p>

                    <p>
                        <strong>Điểm đến:</strong> 
                        {{ optional(optional($group->trip)->tour)->destination ?? '' }}
                    </p>

                    <p>
                        <strong>Thời gian:</strong> 
                        {{ optional(optional($group->trip)->tour)->duration ?? '' }}
                    </p>

                    <p><strong>Mã đoàn:</strong> #{{ $group->id }}</p>

                    <p>
                        <strong>Loại đoàn:</strong> 
                        {{ $group->type ?? '' }}
                    </p>

                    <p>
                        <strong>Hướng dẫn viên:</strong> 
                        {{ $group->guide->name ?? 'Chưa phân công' }}
                    </p>
                </div>

                <!-- RIGHT -->
                <div class="col-md-6">

                    <p>
                        <strong>Ngày đi:</strong> 
                        {{ optional($group->trip)->start_date }}
                    </p>

                    <p>
                        <strong>Ngày kết thúc:</strong> 
                        {{ optional($group->trip)->end_date }}
                    </p>

                    <p>
                        <strong>Số người:</strong> 
                        {{ $group->current_people ?? 0 }}/{{ $group->max_people ?? 0 }}
                    </p>

                    <p>
                        <strong>Trạng thái:</strong> 
                        @if($group->status == 'open')
                            <span class="badge bg-success">Đang mở</span>
                        @elseif($group->status == 'completed')
                            <span class="badge bg-secondary">Đã hoàn thành</span>
                        @elseif($group->status == 'closed')
                            <span class="badge bg-danger">Đã đóng</span>
                        @else
                            <span class="badge bg-warning">Khác</span>
                        @endif
                    </p>

                    <p>
                        <strong>Ghi chú:</strong> 
                        {{ $group->note ?? 'Không có' }}
                    </p>

                </div>

            </div>

        </div>
    </div>


    <!-- NÚT CHỨC NĂNG -->
    <div class="mb-4">

        <a href="{{ route('guide.customers', $group->id) }}" 
           class="btn btn-primary">
            👥 Danh sách khách
        </a>

        <a href="{{ route('guide.attendance', $group->id) }}" 
           class="btn btn-success">
            ✅ Điểm danh
        </a>

    </div>


    <!-- DANH SÁCH KHÁCH -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Danh sách khách trong đoàn
        </div>

        <div class="card-body p-0">

            <table class="table table-bordered mb-0">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tên khách</th>
                        <th>Email</th>
                        <th>SĐT</th>
                    </tr>
                </thead>

                <tbody>
                    @php $stt = 1; @endphp

                    @forelse($group->bookings as $booking)
                        @foreach($booking->customers ?? [] as $customer)
                        <tr>
                            <td>{{ $stt++ }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email ?? '' }}</td>
                            <td>{{ $customer->phone ?? '' }}</td>
                        </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Không có khách
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection