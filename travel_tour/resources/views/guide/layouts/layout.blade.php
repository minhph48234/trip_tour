<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">
<title>Guide Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">

<div class="container-fluid">

<a class="navbar-brand" href="{{ route('guide.dashboard') }}">
Guide Panel
</a>

<div class="collapse navbar-collapse">

<ul class="navbar-nav me-auto">

<li class="nav-item">
<a class="nav-link" href="{{ route('guide.dashboard') }}">
Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('guide.groups') }}">
Tour của tôi
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('guide.history') }}">
Lịch sử tour đã dẫn
</a>
</li>

</ul>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="btn btn-danger btn-sm">
Đăng xuất
</button>
</form>

</div>

</div>

</nav>


<div class="container mt-4">

<h4 class="mb-4">
@yield('title')
</h4>

@yield('content')

</div>

</body>
</html>