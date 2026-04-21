@extends('layouts.client')

@section('title','Đặt tour')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-4">

<div class="grid md:grid-cols-4 gap-8">

{{-- ================= TOUR INFO ================= --}}
<div class="bg-white shadow-xl rounded-2xl p-6 border">
<h2 class="text-xl font-bold mb-4">Thông tin tour</h2>

<p><b>Tên tour:</b> {{ $trip->tour->name }}</p>
<p><b>Ngày khởi hành:</b> {{ \Carbon\Carbon::parse($trip->start_date)->format('d/m/Y') }}</p>
<p><b>Ngày kết thúc:</b> {{ \Carbon\Carbon::parse($trip->end_date)->format('d/m/Y') }}</p>

<p><b>Giá người lớn:</b> <span class="text-red-600 font-bold">{{ number_format($trip->tour->price) }} VNĐ</span></p>
<p><b>Giá trẻ em:</b> <span class="text-red-600 font-bold">{{ number_format($trip->tour->child_price) }} VNĐ</span></p>

<p><b>Số chỗ còn:</b> {{ $trip->max_people - $trip->current_people }}</p>
</div>

{{-- ================= FORM ================= --}}
<div class="md:col-span-3 bg-white shadow-xl rounded-2xl p-8 border">

<h2 class="text-2xl font-bold mb-6">Thông tin đặt tour</h2>

{{-- ERROR --}}
@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    @foreach ($errors->all() as $error)
        <p>- {{ $error }}</p>
    @endforeach
</div>
@endif

<form action="{{ route('booking.store') }}" method="POST">
@csrf

<input type="hidden" name="trip_id" value="{{ $trip->id }}">
<input type="hidden" name="total_price" id="total_price">

{{-- THÔNG TIN NGƯỜI ĐẶT --}}
<div class="space-y-4">

<input type="text" name="customer_name" placeholder="Họ tên"
class="w-full border px-3 py-2 rounded"
value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>

<input type="text" name="customer_phone" placeholder="SĐT"
class="w-full border px-3 py-2 rounded"
value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>

<input type="email" name="customer_email" placeholder="Email"
class="w-full border px-3 py-2 rounded"
value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>

<input type="number" id="total_people" name="total_people"
min="1"
value="1"
class="w-full border px-3 py-2 rounded">
</div>

{{-- TABLE --}}
<div class="overflow-x-auto mt-6">
<table class="w-full border">
<thead>
<tr class="bg-gray-100">
<th>#</th>
<th>Họ tên</th>
<th>SĐT</th>
<th>Giới tính</th>
<th>Ngày sinh</th>
<th>Tuổi</th>
<th>Loại</th>
</tr>
</thead>
<tbody id="customerList"></tbody>
</table>
</div>

{{-- TOTAL --}}
<div class="mt-6 bg-gray-50 p-4 rounded">
<p>Người lớn: <span id="adultCount">0</span></p>
<p>Trẻ em: <span id="childCount">0</span></p>

<hr class="my-2">

<p class="font-bold">
Tổng: <span id="grandTotal">0</span> VNĐ
</p>

<p class="text-blue-600 font-bold">
Tiền cọc: <span id="deposit">0</span> VNĐ
</p>
</div>

<button class="mt-4 bg-blue-600 text-white px-6 py-3 rounded">
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

function calculateAge(date){
    let today = new Date();
    let birth = new Date(date);
    let age = today.getFullYear() - birth.getFullYear();

    let m = today.getMonth() - birth.getMonth();
    if(m < 0 || (m === 0 && today.getDate() < birth.getDate())){
        age--;
    }
    return age;
}

function render(){
let n = parseInt(input.value) || 1;
list.innerHTML = "";

for(let i=0;i<n;i++){

list.innerHTML += `
<tr>
<td>${i+1}</td>

<td>
<input name="customers[${i}][name]" required class="border w-full px-2 py-1">
</td>

<td>
<input name="customers[${i}][phone]" required class="border w-full px-2 py-1">
</td>

<td>
<select name="customers[${i}][gender]" class="border w-full px-2 py-1">
<option value="male">Nam</option>
<option value="female">Nữ</option>
</select>
</td>

<td>
<input type="date"
name="customers[${i}][birthdate]"
class="birth border w-full px-2 py-1" required>
</td>

<td>
<input type="text" class="age border w-full px-2 py-1 bg-gray-100" readonly>
</td>

<td>
<input type="text" class="type border w-full px-2 py-1 bg-gray-100" readonly>
<input type="hidden" name="customers[${i}][type]" class="typeHidden">
</td>

</tr>
`;
}

bind();
calc();
}

function bind(){
document.querySelectorAll('.birth').forEach(input=>{
input.addEventListener('change', function(){

let row = this.closest('tr');
let age = calculateAge(this.value);

row.querySelector('.age').value = age;

let type = age < 12 ? 'child' : 'adult';
let text = age < 12 ? 'Trẻ em' : 'Người lớn';

row.querySelector('.type').value = text;
row.querySelector('.typeHidden').value = type;

calc();
});
});
}

function calc(){
let adult=0, child=0;

document.querySelectorAll('.typeHidden').forEach(e=>{
if(e.value=='adult') adult++;
if(e.value=='child') child++;
});

let total = adult * price + child * childPrice;
let deposit = total * 0.5;

document.getElementById('adultCount').innerText = adult;
document.getElementById('childCount').innerText = child;
document.getElementById('grandTotal').innerText = total.toLocaleString('vi-VN');
document.getElementById('deposit').innerText = deposit.toLocaleString('vi-VN');

document.getElementById('total_price').value = total;
}

input.addEventListener('input', render);

render();

});
</script>

@endsection