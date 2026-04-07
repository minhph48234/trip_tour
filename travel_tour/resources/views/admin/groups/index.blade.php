@extends('admin.layouts.layout')

@section('content_title','Quản lý đoàn du lịch')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách đoàn</h5>
    </div>

    <div class="card-body">

        {{-- ================= SEARCH ================= --}}
        <form method="GET" class="row mb-4">

            <div class="col-md-4">
                <input type="text"
                       name="keyword"
                       value="{{ request('keyword') }}"
                       class="form-control"
                       placeholder="Tìm theo tên tour...">
            </div>

            <div class="col-md-3">
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>

                <a href="{{ route('admin.groups.index') }}"
                   class="btn btn-secondary">
                    Reset
                </a>
            </div>

        </form>


        {{-- ================= TABLE ================= --}}
        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light text-center">
                    <tr>
                        <th width="60">ID</th>
                        <th>Tour</th>
                        <th>Ngày đi</th>
                        <th>Ngày về</th>
                        <th>Số khách</th>
                        <th>Hướng dẫn viên</th>
                        <th width="120">Hành động</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($groups as $group)

                    <tr>

                        {{-- ID --}}
                        <td class="text-center">{{ $group->id }}</td>

                        {{-- TOUR --}}
                        <td>
                            <strong>
                                {{ $group->trip->tour->name ?? 'N/A' }}
                            </strong>
                        </td>

                        {{-- NGÀY ĐI --}}
                        <td class="text-center">
                            {{ $group->trip->start_date->format('d/m/Y') }}
                        </td>

                        {{-- NGÀY VỀ --}}
                        <td class="text-center">
                            {{ $group->trip->end_date->format('d/m/Y') }}
                        </td>

                        {{-- SỐ KHÁCH --}}
                        <td class="text-center">
                            <span class="badge bg-info">
                                {{ $group->current_people }}/{{ $group->max_people }}
                            </span>
                        </td>

                        {{-- GUIDE --}}
                        <td class="text-center">
                            @if($group->guide)
                                {{ $group->guide->name }}
                            @else
                                <span class="text-muted">Chưa phân công</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="text-center">

                            <a href="{{ route('admin.groups.show',$group->id) }}"
                               class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Không có dữ liệu
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $groups->appends(request()->query())->links() }}
        </div>

    </div>

</div>

@endsection