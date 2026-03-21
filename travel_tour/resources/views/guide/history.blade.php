@extends('guide.layouts.layout')

@section('content_title', 'Lịch sử tour đã dẫn')

@section('content')

<div class="bg-white shadow-xl rounded-2xl p-6">

    <h2 class="text-2xl font-bold mb-6">
        Lịch sử tour đã dẫn
    </h2>

    @if($groups->count())

    <div class="overflow-x-auto">

        <table class="w-full text-center border rounded-xl overflow-hidden">

            <thead class="bg-gray-100">

                <tr>
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">Tên tour</th>
                    <th class="p-3 border">Ngày khởi hành</th>
                    <th class="p-3 border">Số khách</th>
                    <th class="p-3 border">Trạng thái</th>
                </tr>

            </thead>

            <tbody>

                @foreach($groups as $index => $group)

                <tr class="hover:bg-gray-50 transition">

                    <td class="p-3 border">
                        {{ $index + 1 }}
                    </td>

                    <td class="p-3 border font-semibold text-left">
                        {{ $group->trip->tour->name ?? '---' }}
                    </td>

                    <td class="p-3 border">
                        {{ $group->trip->departure_date ?? '---' }}
                    </td>

                    <td class="p-3 border">
                        {{ $group->current_people }} / {{ $group->max_people }}
                    </td>

                    <td class="p-3 border">

                        @php
                            $statusText = match($group->status){
                                'completed' => 'Đã hoàn thành',
                                'running' => 'Đang diễn ra',
                                'cancelled' => 'Đã huỷ',
                                default => $group->status
                            };

                            $statusColor = match($group->status){
                                'completed' => 'bg-green-100 text-green-700',
                                'running' => 'bg-blue-100 text-blue-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-lg text-sm font-semibold {{ $statusColor }}">
                            {{ $statusText }}
                        </span>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @else

    <div class="text-center py-10 text-gray-500">
        Chưa có tour nào đã dẫn.
    </div>

    @endif

</div>

@endsection