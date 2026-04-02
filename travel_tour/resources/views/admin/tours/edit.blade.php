@extends('admin.layouts.layout')

@section('content_title', 'Cập nhật tour')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.tours.update', $tour->id) }}" 
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="card mb-4">
        <div class="card-body">

            <div class="mb-3">
                <label>Tên tour</label>
                <input type="text" name="name"
                       value="{{ old('name', $tour->name) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == $tour->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Điểm đi</label>
                    <input type="text" name="departure_location"
                           value="{{ $tour->departure_location }}"
                           class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Điểm đến</label>
                    <input type="text" name="destination"
                           value="{{ $tour->destination }}"
                           class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>Mô tả</label>
                <textarea name="description"
                          class="form-control"
                          rows="4">{{ $tour->description }}</textarea>
            </div>

        </div>
    </div>

    <button class="btn btn-primary mb-4">Cập nhật tour</button>

</form>

{{-- ================= ITINERARY ================= --}}
<div class="card">
    <div class="card-header">
        <h5>📅 Lịch trình tour</h5>
    </div>

    <div class="card-body">

        {{-- FORM THÊM --}}
        <form action="{{ route('admin.tours.itineraries.store', $tour->id) }}" method="POST">
            @csrf

            <div class="row mb-3">

                <div class="col-md-2">
                    <input type="number" name="day" class="form-control" placeholder="Ngày" required>
                </div>

                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="Tiêu đề" required>
                </div>

                <div class="col-md-4">
                    <input type="text" name="description" class="form-control" placeholder="Mô tả">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success w-100">+ Thêm</button>
                </div>

            </div>

        </form>

        {{-- DANH SÁCH --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th width="100">Xoá</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tour->itineraries->sortBy('day') as $item)
                <tr>
                    <td>Ngày {{ $item->day }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <form action="{{ route('admin.itineraries.destroy',$item->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Xoá?')" 
                                    class="btn btn-danger btn-sm">
                                X
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Chưa có lịch trình
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection