<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">
<title>Guide Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
    <a class="nav-link" href="{{ route('guide.dashboard') }}">Dashboard</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('guide.groups') }}">Tour của tôi</a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('guide.history') }}">Lịch sử</a>
</li>

</ul>

{{-- 🔔 NOTIFICATION ICON --}}
@php
    $notifications = auth()->user()->notifications ?? collect();
    $unreadCount = auth()->user()->unreadNotifications->count() ?? 0;
@endphp

<div class="dropdown me-3">

    <a class="btn btn-dark position-relative" id="bellBtn" data-bs-toggle="dropdown">
        <i class="bi bi-bell fs-5"></i>

        @if($unreadCount > 0)
            <span id="notiBadge"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px">

        <li class="fw-bold mb-2">Thông báo</li>

        @forelse($notifications->take(5) as $noti)

            @php
                $group = \App\Models\Group::with('trip.tour')
                    ->find($noti->data['group_id'] ?? null);
            @endphp

            <li class="mb-2 border-bottom pb-2">

                {{-- MESSAGE --}}
                <small class="text-dark d-block">
                    {{ $noti->data['message'] ?? 'Thông báo mới' }}
                </small>

                {{-- TOUR INFO --}}
                @if($group && $group->trip)

                    <small class="text-primary d-block">
                        🧳 {{ $group->trip->tour->name ?? '' }}
                    </small>

                    <small class="text-muted d-block">
                        📅 {{ $group->trip->start_date->format('d/m/Y') }}
                        → {{ $group->trip->end_date->format('d/m/Y') }}
                    </small>

                @endif

                {{-- BUTTON --}}
                @if($group)
                    <a href="{{ route('guide.groups.detail', $group->id) }}"
                    class="btn btn-sm btn-primary mt-1">
                        Xem chi tiết
                    </a>
                @endif

            </li>

        @empty

            <li class="text-muted">Không có thông báo</li>

        @endforelse

    </ul>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('bellBtn').addEventListener('click', function () {

    fetch("{{ route('guide.notifications.read') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            let badge = document.getElementById('notiBadge');
            if(badge){
                badge.remove(); // 🔥 Ẩn badge luôn
            }
        }
    });

});
</script>
</body>
</html>