@extends('admin.layouts.layout')

@section('content_title','Danh sách tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="mb-0">Danh sách tour</h4>

    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm tour
    </a>

</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<table class="table table-bordered table-hover align-middle">

    <thead class="table-light">
        <tr>
            <th width="60">ID</th>
            <th width="120">Ảnh</th>
            <th>Tên tour</th>
            <th>Danh mục</th>
            <th>Điểm đi</th>
            <th>Điểm đến</th>
            <th>Thời gian</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th width="180">Hành động</th>
        </tr>
    </thead>

    <tbody>

        @forelse($tours as $tour)

        <tr>

            <td>{{ $tour->id }}</td>

            <td>
                @if($tour->thumbnail)
                    <img src="{{ asset('storage/'.$tour->thumbnail) }}"
                        width="100"
                        height="70"
                        style="object-fit:cover;border-radius:6px;">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>

            <td>
                <strong>{{ $tour->name }}</strong>
            </td>

            <td>
                {{ $tour->category->name ?? 'Không có' }}
            </td>

            <td>{{ $tour->departure_location }}</td>

            <td>{{ $tour->destination }}</td>

            <td>{{ $tour->duration }}</td>

            <td>
                {{ number_format($tour->price,0,',','.') }} VNĐ
            </td>

            <td>
                @if($tour->status)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>

            <td>

                <a href="{{ route('admin.tours.show',$tour->id) }}"
                   class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                </a>

                <a href="{{ route('admin.tours.edit',$tour->id) }}"
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('admin.tours.destroy',$tour->id) }}"
                      method="POST"
                      style="display:inline-block">

                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Bạn chắc chắn muốn xoá tour?')"
                            class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="10" class="text-center">
                Không có dữ liệu
            </td>
        </tr>

        @endforelse

    </tbody>

</table>


<div class="mt-3">
    {{ $tours->links() }}
</div>

@endsection