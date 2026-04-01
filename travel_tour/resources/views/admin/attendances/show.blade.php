@extends('admin.layouts.layout')

@section('title','Chi tiết điểm danh')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">📊 Chi tiết điểm danh</h1>

    <!-- Thông tin -->
    <div class="bg-white p-5 rounded shadow mb-6">
        <p><b>Tour:</b> {{ $attendance->trip->tour->title ?? '' }}</p>
        <p><b>Đoàn:</b> #{{ $attendance->group_id }}</p>
        <p><b>Guide:</b> {{ $attendance->guide->name ?? '' }}</p>
        <p><b>Ngày:</b> {{ $attendance->attendance_date }}</p>
        <p><b>Buổi:</b> {{ ucfirst($attendance->session) }}</p>
    </div>

    <!-- Thống kê -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded">Tổng: {{ $total }}</div>
        <div class="bg-green-100 p-4 rounded">Có mặt: {{ $present }}</div>
        <div class="bg-red-100 p-4 rounded">Vắng: {{ $absent }}</div>
        <div class="bg-yellow-100 p-4 rounded">Trễ: {{ $late }}</div>
    </div>

    <!-- Danh sách -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Khách</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Ghi chú</th>
                </tr>
            </thead>

            <tbody>
                @foreach($attendance->details as $detail)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $detail->customer->name ?? '' }}
                    </td>

                    <td class="p-3">
                        @if($detail->status == 'present')
                            <span class="text-green-600">Có mặt</span>
                        @elseif($detail->status == 'absent')
                            <span class="text-red-600">Vắng</span>
                        @else
                            <span class="text-yellow-600">Trễ</span>
                        @endif
                    </td>

                    <td class="p-3">
                        {{ $detail->note }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection