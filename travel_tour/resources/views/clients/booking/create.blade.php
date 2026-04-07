@extends('layouts.client')

@section('title','Đặt tour')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-4">

<div class="grid md:grid-cols-4 gap-8">

{{-- ================= TOUR INFO ================= --}}
<div class="bg-white shadow-xl rounded-2xl p-6 border">

<h2 class="text-xl font-bold mb-4 text-slate-800">
Thông tin tour
</h2>

<p><b>Tên tour:</b> {{ $trip->tour->name }}</p>

<p><b>Ngày khởi hành:</b>
{{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}
</p>

<p><b>Ngày kết thúc:</b>
{{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}
</p>

<p><b>Giá người lớn:</b>
<span class="text-red-600 font-bold">
{{ number_format($trip->tour->price) }} VNĐ
</span>
</p>

<p><b>Giá trẻ em:</b>
<span class="text-red-600 font-bold">
{{ number_format($trip->tour->child_price) }} VNĐ
</span>
</p>

<p><b>Số chỗ còn:</b>
{{ $trip->max_people - $trip->current_people }}
</p>

</div>


{{-- ================= FORM ================= --}}
<div class="md:col-span-3 bg-white shadow-xl rounded-2xl p-8 border">

<h2 class="text-2xl font-bold mb-6 text-slate-800">
Thông tin đặt tour
</h2>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
{{ session('error') }}
</div>
@endif

<form action="{{ route('booking.store') }}" method="POST" class="space-y-5">
@csrf

<input type="hidden" name="trip_id" value="{{ $trip->id }}">
<input type="hidden" name="total_price" id="total_price">

{{-- HỌ TÊN --}}
<div>
    <label>Họ tên</label>
    <input type="text"
           name="customer_name"
         
           class="w-full border rounded px-3 py-2"
           value="{{ old('customer_name', auth()->user()->name ?? '') }}">
           @error('customer_name')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

{{-- SĐT --}}
<div>
<label>SĐT</label>
<input type="text"
       name="customer_phone"
       
       pattern="^(0|\+84)[0-9]{9}$"
       title="Số điện thoại phải bắt đầu bằng 0 hoặc +84 và đủ 10 số"
       class="w-full border rounded px-3 py-2 bg-blue-50
              @error('customer_phone') border-red-500 @enderror"
       value="{{ old('customer_phone', auth()->user()->phone ?? '') }}">

@error('customer_phone')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

{{-- EMAIL --}}
<div>
    <label>Email</label>
    <input type="email"
           name="customer_email"
           class="w-full border rounded px-3 py-2"
           value="{{ old('customer_email', auth()->user()->email ?? '') }}">
           @error('customer_email')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>

{{-- SỐ NGƯỜI --}}
<div>
<label>Số khách</label>
<input type="number" id="total_people" name="total_people"
min="1"
max="{{ $trip->max_people - $trip->current_people }}"
value="1"
class="w-full border rounded px-3 py-2">
@error('total_people')
    <p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

{{-- TABLE --}}
<div class="overflow-x-auto">
<table class="min-w-[900px] w-full border mt-4">
<thead>
<tr>
<th>#</th>
<th>Họ tên</th>
<th>SĐT</th>
<th>Giới tính</th>
<th>Ngày sinh</th>
<th>Loại</th>
</tr>
</thead>
<tbody id="customerList"></tbody>
</table>
</div>

{{-- ================= TỔNG TIỀN ================= --}}
<div class="bg-gray-50 p-4 rounded mt-6">

<p>Người lớn:
<span id="adultCount">0</span> x {{ number_format($trip->tour->price) }} =
<span id="adultTotal">0</span>
</p>

<p>Trẻ em:
<span id="childCount">0</span> x {{ number_format($trip->tour->child_price) }} =
<span id="childTotal">0</span>
</p>

<hr class="my-2">

<p class="font-bold">
Tổng:
<span id="grandTotal" class="text-red-600 text-xl">0</span> VNĐ
</p>

<p class="text-blue-600 font-bold mt-2">
Tiền cọc (50%):
<span id="deposit">0</span> VNĐ
</p>

</div>

<button class="bg-blue-600 text-white px-6 py-3 rounded">
Thanh toán tiền cọc
</button>

</form>

</div>

</div>

</div>


<script>
document.addEventListener("DOMContentLoaded", function(){

const price = {{ $trip->tour->price }};
const childPrice = {{ $trip->tour->child_price }};

const list = document.getElementById('customerList');
const input = document.getElementById('total_people');

function render(){

let n = parseInt(input.value) || 1;
list.innerHTML = "";

for(let i=0;i<n;i++){
list.innerHTML += `
<tr>
<td>${i+1}</td>

<td>
<input name="customers[${i}][name]"  class="border px-2 py-1 w-full">
</td>

<td>
<input name="customers[${i}][phone]"  class="border px-2 py-1 w-full">
</td>

<td>
<select name="customers[${i}][gender]"  class="border px-2 py-1 w-full">
<option value="male">Nam</option>
<option value="female">Nữ</option>
</select>
</td>

<td>
<input type="date" name="customers[${i}][birthdate]"  class="border px-2 py-1 w-full min-w-[140px]">
</td>

<td>
<select class="type" name="customers[${i}][type]" class="border px-2 py-1 w-full">
<option value="adult">Người lớn</option>
<option value="child">Trẻ em</option>
</select>
</td>

</tr>
`;
}

bind();
calc();
}

function bind(){
document.querySelectorAll('.type').forEach(e=>{
e.addEventListener('change', calc);
});
}

function calc(){

let adult=0, child=0;

document.querySelectorAll('.type').forEach(e=>{
if(e.value=='adult') adult++;
else child++;
});

let totalAdult = adult * price;
let totalChild = child * childPrice;
let total = totalAdult + totalChild;
let deposit = total * 0.5;

document.getElementById('adultCount').innerText = adult;
document.getElementById('childCount').innerText = child;

document.getElementById('adultTotal').innerText = format(totalAdult);
document.getElementById('childTotal').innerText = format(totalChild);
document.getElementById('grandTotal').innerText = format(total);
document.getElementById('deposit').innerText = format(deposit);

document.getElementById('total_price').value = total;
}

function format(n){
return n.toLocaleString('vi-VN');
}

input.addEventListener('input', render);

render();

});
</script>

@endsection