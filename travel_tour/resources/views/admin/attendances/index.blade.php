@extends('admin.layouts.layout')

@section('title','Quản lý điểm danh')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">📋 Danh sách điểm danh</h1>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Tour</th>
                    <th class="p-3">Đoàn</th>
                    <th class="p-3">Hướng dẫn viên</th>
                    <th class="p-3">Ngày</th>
                    <th class="p-3">Buổi</th>
                    <th class="p-3 text-center">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($attendances as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $item->id }}</td>

                    <td class="p-3">
                        {{ $item->trip->tour->title ?? 'N/A' }}
                    </td>

                    <td class="p-3">
                        #{{ $item->group_id }}
                    </td>

                    <td class="p-3">
                        {{ $item->guide->name ?? 'N/A' }}
                    </td>

                    <td class="p-3">
                        {{ $item->attendance_date }}
                    </td>

                    <td class="p-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">
                            {{ ucfirst($item->session) }}
                        </span>
                    </td>

                    <td class="btn btn-primary">
                        <a href="{{ route('admin.attendances.show', $item->id) }}"
                           class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            Xem
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-5 text-gray-500">
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $attendances->links() }}
    </div>

</div>

@endsection