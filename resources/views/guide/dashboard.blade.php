<!-- <h1>Guide Dashboard</h1>

<form method="POST" action="/logout">
@csrf
<button>Logout</button>
</form> -->

@extends('guide.layouts.layout')

@section('title','Dashboard')

@section('content')

<div class="alert alert-info">
Chào mừng hướng dẫn viên <b>{{ auth()->user()->name }}</b>
</div>

<a href="{{ route('guide.groups') }}" class="btn btn-primary">
Xem tour được phân công
</a>

@endsection