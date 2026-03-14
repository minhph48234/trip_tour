<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị hệ thống - TravelGo')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --primary-color: #2563eb;
        }

        body { 
            background-color: #f1f5f9; 
            font-family: 'Lexend', sans-serif; 
            margin: 0; 
            overflow-x: hidden;
        }

        /* KHẮC PHỤC LỖI ICON KHỔNG LỒ */
        i, svg {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            /* Khống chế kích thước tối đa để không bị vỡ khi chưa load kịp CSS */
            max-width: 1em; 
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .admin-main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-admin {
            background: white;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .admin-content {
            padding: 30px;
            flex-grow: 1;
        }

        .main-content-card {
            background: white !important;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 25px !important;
            min-height: 400px;
            /* Đảm bảo nội dung không tràn ra ngoài */
            overflow: hidden; 
        }

        .content-loading {
            opacity: 0.4;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        
        /* Sidebar active style */
        .admin-sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: white !important;
            border-left: 4px solid var(--primary-color);
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <aside class="admin-sidebar">
            @include('admin.sidebar')
        </aside>

        <div class="admin-main">
            <header class="header-admin">
                <h5 class="fw-bold mb-0 text-dark text-uppercase small" style="letter-spacing: 1px;">Hệ thống quản trị</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3 small text-muted d-none d-md-inline">Chào, <strong>Quản trị viên</strong></span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; font-size: 0.8rem;">AD</div>
                </div>
            </header>

            <div class="admin-content">
                <div id="ajax-content-wrapper">
                    <div class="main-content-card">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Xử lý AJAX load trang
            $(document).on('click', 'aside a, .nav-link-admin', function(e) {
                const url = $(this).attr('href');

                if (!url || url.includes('#') || url.includes('logout') || url.startsWith('javascript') || url === '') {
                    return;
                }

                e.preventDefault();
                $('#ajax-content-wrapper').addClass('content-loading');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // Tìm phần nội dung mới trong response
                        const tempDom = $('<div/>').append($.parseHTML(response));
                        const newHtml = tempDom.find('#ajax-content-wrapper').html();
                        
                        if (newHtml) {
                            $('#ajax-content-wrapper').html(newHtml);
                            window.history.pushState({path: url}, '', url);
                            
                            // Cập nhật trạng thái active sidebar
                            $('aside a').removeClass('active');
                            $(`aside a[href="${url}"]`).addClass('active');
                        } else {
                            window.location.href = url;
                        }
                    },
                    error: function() {
                        window.location.href = url;
                    },
                    complete: function() {
                        $('#ajax-content-wrapper').removeClass('content-loading');
                        window.scrollTo(0, 0);
                    }2
                });
            });

            window.onpopstate = function() {
                location.reload(); 
            };
        });
    </script>
</body>
</html>