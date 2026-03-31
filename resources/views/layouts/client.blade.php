<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hệ thống Quản lý Tour Du Lịch')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600;700&display=swap');
        body { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    @include('clients.blocks.header')

    <main>
        @yield('banner') 

        <div class="content">
            @yield('content')
        </div>
    </main>

    @include('clients.blocks.footer')

    @stack('scripts')
</body>
</html>