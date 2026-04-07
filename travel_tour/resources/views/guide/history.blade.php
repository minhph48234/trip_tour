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
                    <th class="p-3 border">Ngày đi</th>
                    <th class="p-3 border">Ngày về</th>
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
                        {{ $group->trip->start_date ?? '---' }}
                    </td>

                    <td class="p-3 border">
                        {{ $group->trip->end_date ?? '---' }}
                    </td>

                    <td class="p-3 border">
                        {{ $group->current_people }} / {{ $group->max_people }}
                    </td>

                    <td class="p-3 border">
                        <span class="px-3 py-1 rounded-lg text-sm font-semibold bg-green-100 text-green-700">
                            Hoàn thành
                        </span>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @else

    <div class="text-center py-10 text-gray-500">
        Chưa có tour nào đã hoàn thành.
    </div>

    @endif

</div>

@endsection