<div class="p-4 sidebar-brand">
    <h4 class="text-white fw-bold mb-0">TRAVEL<span class="text-primary">GO</span></h4>
    <p class="text-muted small mb-0" style="font-size: 0.7rem; letter-spacing: 2px;">ADMINISTRATOR</p>
</div>

<nav class="mt-3 flex-column d-flex">
    <a href="/admin" class="nav-link-admin {{ Request::is('admin') ? 'active' : '' }}">
        <i class="fa fa-tachometer-alt me-3"></i> Dashboard
    </a>

    <div class="nav-item">
        <a href="#submenu-categories" data-bs-toggle="collapse" class="nav-link-admin d-flex justify-content-between align-items-center {{ Request::is('admin/categories*') ? 'active' : '' }}">
            <span><i class="fa fa-list me-3"></i> Danh mục tour</span>
            <i class="fa fa-chevron-down small opacity-50"></i>
        </a>
        <div class="collapse {{ Request::is('admin/categories*') ? 'show' : '' }}" id="submenu-categories">
            <div class="bg-dark-subtle py-2">
                <a href="{{ route('admin.categories.index') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Tất cả danh mục
                </a>
                <a href="/admin/categories/create" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Thêm mới
                </a>
            </div>
        </div>
    </div>

    <div class="nav-item">
        <a href="#submenu-tours" data-bs-toggle="collapse" class="nav-link-admin d-flex justify-content-between align-items-center {{ Request::is('admin/tours*') ? 'active' : '' }}">
            <span><i class="fa fa-map-marker-alt me-3"></i> Quản lý tour</span>
            <i class="fa fa-chevron-down small opacity-50"></i>
        </a>
        <div class="collapse {{ Request::is('admin/tours*') ? 'show' : '' }}" id="submenu-tours">
            <div class="bg-dark-subtle py-2">
                <a href="{{ route('admin.tours.index') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Danh sách tour
                </a>

                <a href="{{ route('admin.tours.create') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Thêm tour mới
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="nav-item">
        <a href="#submenu-guides" data-bs-toggle="collapse" class="nav-link-admin d-flex justify-content-between align-items-center {{ Request::is('admin/guides*') ? 'active' : '' }}">
            <span><i class="fa fa-user-tie me-3"></i> Hướng dẫn viên</span>
            <i class="fa fa-chevron-down small opacity-50"></i>
        </a>
        <div class="collapse {{ Request::is('admin/guides*') ? 'show' : '' }}" id="submenu-guides">
            <div class="bg-dark-subtle py-2">
                <a href="{{ route('admin.guides.index') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Danh sách HDV
                </a>

                <a href="{{ route('admin.guides.create') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Thêm HDV mới
                </a>
            </div>
        </div>
    </div>

    <div class="nav-item">
        <a href="#submenu-users" data-bs-toggle="collapse" class="nav-link-admin d-flex justify-content-between align-items-center {{ Request::is('admin/users*') ? 'active' : '' }}">
            <span><i class="fa fa-users me-3"></i> Người dùng</span>
            <i class="fa fa-chevron-down small opacity-50"></i>
        </a>
        <div class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" id="submenu-users">
            <div class="bg-dark-subtle py-2">
                <a href="{{ route('admin.users.index') }}" class="nav-link-admin py-2 ps-5 small">
                    <i class="fa fa-angle-right me-2"></i> Tài khoản khách
                </a>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" 
        class="nav-link-admin {{ Request::is('admin/bookings*') ? 'active' : '' }}">

        <i class="fa fa-shopping-cart me-3"></i>
        Đơn đặt tour

    </a>

    
    <a href="{{ route('admin.trips.index') }}" 
        class="nav-link-admin {{ Request::is('admin/trips*') ? 'active' : '' }}">
        
        <i class="nav-icon fas fa-calendar-alt"></i>
        <span> Quản lý lịch khởi hành</span>

    </a>

    <a href="{{ route('admin.groups.index') }}" 
        class="nav-link-admin {{ Request::is('admin/groups*') ? 'active' : '' }}">
        
        <i class="fa fa-route me-3"></i> 
            <span>
                Quản lý đoàn khởi hành
            </span>
    </a>




        <form method="POST" action="/logout">
        @csrf
        <button>Logout</button>
        </form>
        <style>
    .nav-link-admin {
        padding: 14px 25px;
        color: #94a3b8 !important;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: 0.3s;
        cursor: pointer;
    }
    .nav-link-admin:hover {
        background: rgba(255,255,255,0.05);
        color: white !important;
    }
    .nav-link-admin.active {
        background: var(--primary-color) !important;
        color: white !important;
        border-right: 4px solid white;
    }
    /* Style cho vùng menu con */
    .bg-dark-subtle {
        background-color: rgba(0, 0, 0, 0.2) !important;
    }
    .nav-link-admin.small {
        font-size: 0.85rem;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    /* Xoay icon khi mở menu */
    [aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
        transition: 0.3s;
    }
</style>