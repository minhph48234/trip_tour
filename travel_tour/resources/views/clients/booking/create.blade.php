@extends('layouts.client')

@section('title','Đặt tour')

@section('content')

<div class="max-w-5xl mx-auto py-12 px-4">

<div class="grid md:grid-cols-3 gap-8">

{{-- ================= TOUR INFO ================= --}}
<div class="bg-white shadow-xl rounded-2xl p-6 border">

<h2 class="text-xl font-bold mb-4 text-slate-800">
Thông tin tour
</h2>

<p class="mb-2">
<b>Tên tour:</b> {{ $trip->tour->name }}
</p>

<p class="mb-2">
<b>Ngày khởi hành:</b>
{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
</p>

<p class="mb-2">
<b>Ngày kết thúc:</b>
{{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}
</p>

<p class="mb-2">
<b>Giá người lớn:</b>
<span class="text-red-600 font-bold">
{{ number_format($trip->tour->price) }} VNĐ
</span>
</p>

<p class="mb-2">
<b>Giá trẻ em:</b>
<span class="text-red-600 font-bold">
{{ number_format($trip->tour->child_price) }} VNĐ
</span>
</p>

<p>
<b>Số chỗ còn:</b>
{{ $trip->max_people - $trip->current_people }}
</p>

</div>


{{-- ================= FORM BOOKING ================= --}}
<div class="md:col-span-2 bg-white shadow-xl rounded-2xl p-8 border">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Thông tin đặt tour
</h2>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
{{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="{{ route('booking.store') }}" method="POST" class="space-y-5">

@csrf

<input type="hidden" name="trip_id" value="{{ $trip->id }}">


{{-- HỌ TÊN NGƯỜI ĐẶT --}}
<div>
<label class="block font-semibold mb-1">Họ tên người đặt</label>

<input type="text"
name="customer_name"
required
value="{{ old('customer_name') }}"
class="w-full border rounded-lg px-4 py-2">
</div>


{{-- SĐT --}}
<div>
<label class="block font-semibold mb-1">Số điện thoại</label>

<input type="text"
name="customer_phone"
required
value="{{ old('customer_phone') }}"
class="w-full border rounded-lg px-4 py-2">
</div>


{{-- EMAIL --}}
<div>
<label class="block font-semibold mb-1">Email</label>

<input type="email"
name="customer_email"
value="{{ old('customer_email') }}"
class="w-full border rounded-lg px-4 py-2">
</div>



{{-- SỐ NGƯỜI --}}
<div>
<label class="block font-semibold mb-1">Số khách đi tour</label>

<input type="number"
id="total_people"
name="total_people"
min="1"
max="{{ $trip->max_people - $trip->current_people }}"
value="1"
class="w-full border rounded-lg px-4 py-2">

<p class="text-sm text-gray-500 mt-1">
Tối đa {{ $trip->max_people - $trip->current_people }} khách
</p>

</div>



{{-- ================= DANH SÁCH KHÁCH ================= --}}
<div>

<h3 class="text-lg font-bold mt-6 mb-3">
Danh sách khách đi tour
</h3>

<div class="overflow-x-auto">

<table class="w-full border border-gray-200 rounded-lg">

<thead class="bg-gray-100">

<tr class="text-left">

<th class="p-2 border w-12">#</th>
<th class="p-2 border">Họ tên</th>
<th class="p-2 border">SĐT</th>
<th class="p-2 border">Giới tính</th>
<th class="p-2 border">Ngày sinh</th>
<th class="p-2 border">Loại khách</th>

</tr>

</thead>

<tbody id="customerList"></tbody>

</table>

</div>

</div>



{{-- BUTTON --}}
<div class="pt-4">

<button
type="submit"
class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">

Thanh Toán

</button>

</div>

</form>

</div>

</div>

</div>



{{-- ================= SCRIPT AUTO TẠO KHÁCH ================= --}}
<script>

document.addEventListener("DOMContentLoaded", function(){

const quantityInput = document.getElementById('total_people');
const customerList = document.getElementById('customerList');

function generateCustomers(){

let quantity = parseInt(quantityInput.value) || 1;

customerList.innerHTML = "";

for(let i = 0; i < quantity; i++){

customerList.innerHTML += `

<tr>

<td class="border p-2 font-bold text-center">
${i+1}
</td>

<td class="border p-2">
<input type="text"
required
name="customers[${i}][name]"
placeholder="Họ tên"
class="w-full border rounded px-2 py-1">
</td>

<td class="border p-2">
<input type="text"
required
name="customers[${i}][phone]"
placeholder="SĐT"
class="w-full border rounded px-2 py-1">
</td>

<td class="border p-2">

<select name="customers[${i}][gender]"
class="w-full border rounded px-2 py-1">

<option value="male">Nam</option>
<option value="female">Nữ</option>

</select>

</td>

<td class="border p-2">
<input type="date"
name="customers[${i}][birthdate]"
class="w-full border rounded px-2 py-1">
</td>

<td class="border p-2">

<select name="customers[${i}][type]"
class="w-full border rounded px-2 py-1">

<option value="adult">Người lớn</option>
<option value="child">Trẻ em</option>

</select>

</td>

</tr>

`;

}

}

quantityInput.addEventListener('input', generateCustomers);

generateCustomers();

});

</script>

@endsection