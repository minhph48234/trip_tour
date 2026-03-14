@extends('admin.layouts.layout')

@section('content_title','Chi tiết tour')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">
        ← Quay lại
    </a>
</div>

<div class="card">
<div class="card-body">

<h2 class="mb-3">{{ $tour->name }}</h2>

<div class="row">

<div class="col-md-6">

{{-- Ảnh đại diện --}}
@if($tour->thumbnail)
<img src="{{ asset('storage/'.$tour->thumbnail) }}"
     class="img-fluid rounded"
     style="max-height:350px;object-fit:cover">
@else
<div class="text-muted">Không có ảnh</div>
@endif

</div>


<div class="col-md-6">

<p>
<strong>Danh mục:</strong>
{{ $tour->category->name ?? 'Không có' }}
</p>

<p>
<strong>Điểm khởi hành:</strong>
{{ $tour->departure_location }}
</p>

<p>
<strong>Điểm đến:</strong>
{{ $tour->destination }}
</p>

<p>
<strong>Thời gian:</strong>
{{ $tour->duration }}
</p>

<p>
<strong>Phương tiện:</strong>
{{ $tour->transport }}
</p>

<p>
<strong>Số người tối đa:</strong>
{{ $tour->max_people }}
</p>

<p>
<strong>Giá người lớn:</strong>
<span class="text-danger fw-bold">
{{ number_format($tour->price,0,',','.') }} VNĐ
</span>
</p>

@if($tour->child_price)
<p>
<strong>Giá trẻ em:</strong>
{{ number_format($tour->child_price,0,',','.') }} VNĐ
</p>
@endif

<p>
<strong>Trạng thái:</strong>

@if($tour->status)
<span class="badge bg-success">Hiển thị</span>
@else
<span class="badge bg-danger">Ẩn</span>
@endif

</p>

</div>

</div>

<hr>

<h4>Mô tả tour</h4>

<div class="mb-4">
{!! $tour->description !!}
</div>


{{-- Highlight --}}
@if($tour->highlight)
<hr>
<h4>Điểm nổi bật</h4>

<div class="mb-4">
{!! $tour->highlight !!}
</div>
@endif


{{-- Gallery images --}}
@if($tour->images->count())

<hr>

<h4>Hình ảnh tour</h4>

<div class="row">

@foreach($tour->images as $img)

<div class="col-md-3 mb-3">

<img src="{{ asset('storage/'.$img->image) }}"
     class="img-fluid rounded"
     style="height:150px;width:100%;object-fit:cover">

</div>

@endforeach

</div>

@endif


{{-- Itinerary --}}
@if($tour->itineraries->count())

<hr>

<h4>Lịch trình</h4>

@foreach($tour->itineraries as $item)

<div class="mb-3 p-3 border rounded">

<h5>
Ngày {{ $item->day }} :
{{ $item->title }}
</h5>

<div>
{!! $item->description !!}
</div>

</div>

@endforeach

@endif


</div>
</div>

@endsection