@extends('admin.layouts.layout')

@section('content_title','Chi tiết đoàn')

@section('content')

<div class="container">

    <h3 class="mb-3">Thông tin đoàn</h3>

    <p><b>Tour:</b> {{ $group->trip->tour->name }}</p>

    <p><b>Ngày:</b> 
        {{ $group->trip->start_date->format('d/m/Y') }} 
        - 
        {{ $group->trip->end_date->format('d/m/Y') }}
    </p>

    <p>
        <b>Số khách:</b> 
        <span class="badge bg-info">
            {{ $group->current_people }}/{{ $group->max_people }}
        </span>
    </p>

    <p><b>Guide hiện tại:</b> 
        @if($group->guide)
            <span class="badge bg-success">{{ $group->guide->name }}</span>
        @else
            <span class="badge bg-secondary">Chưa có</span>
        @endif
    </p>

    <hr>

    {{-- ================= ALERT ================= --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔥 CẢNH BÁO CHƯA ĐỦ KHÁCH --}}
    @if($group->current_people < $group->min_people)
        <div class="alert alert-warning">
            ⚠ Đoàn chưa đủ khách (tối thiểu {{ $group->min_people }} khách). 
            Không thể phân công hướng dẫn viên!
        </div>
    @endif

    {{-- ================= ASSIGN GUIDE ================= --}}
    <h4 class="mb-3">Phân công hướng dẫn viên</h4>

    <form action="{{ route('admin.groups.assignGuide',$group->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <select name="guide_id" class="form-control"
                {{ $group->current_people < $group->min_people ? 'disabled' : '' }}>

                <option value="">-- Chọn hướng dẫn viên --</option>

                @foreach($guides as $guide)

                    @php
                        $isSelected = $group->guide_id == $guide->id;

                        // 🔥 CHECK TRÙNG LỊCH
                        $isBusy = \App\Models\Group::where('guide_id', $guide->id)
                            ->where('id', '!=', $group->id)
                            ->whereHas('trip', function ($q) use ($group) {
                                $q->where(function ($query) use ($group) {
                                    $query->where('start_date', '<=', $group->trip->end_date)
                                          ->where('end_date', '>=', $group->trip->start_date);
                                });
                            })
                            ->exists();
                    @endphp

                    <option value="{{ $guide->id }}"
                        {{ $isSelected ? 'selected' : '' }}
                        {{ ($guide->status == 'inactive' || $isBusy) ? 'disabled' : '' }}
                    >
                        {{ $guide->name }}

                        (
                        @if($guide->status == 'inactive')
                            ❌ Ngừng hoạt động
                        @elseif($isBusy)
                            🔴 Trùng lịch
                        @else
                            🟢 Sẵn sàng
                        @endif
                        )
                    </option>

                @endforeach

            </select>
        </div>

        <button class="btn btn-primary"
            {{ $group->current_people < $group->min_people ? 'disabled' : '' }}>
            Phân công
        </button>
    </form>

    <hr>

    {{-- ================= BOOKING LIST ================= --}}
    <h4 class="mb-3">Danh sách booking</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Khách</th>
                <th>Số người</th>
            </tr>
        </thead>
        <tbody>

        @forelse($group->bookings as $booking)
            <tr>
                <td>{{ $booking->booking_code }}</td>
                <td>{{ $booking->customer_name }}</td>
                <td>{{ $booking->quantity }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Chưa có booking</td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>

@endsection