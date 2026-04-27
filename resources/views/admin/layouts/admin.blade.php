<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quản trị hệ thống') - F8 Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --sidebar-width: 260px; 
            --primary-color: #ee4d2d; 
            --dark-bg: #2b353e; 
            --bg: #f6f7fb;
        }
        
        body { font-family: 'Segoe UI', sans-serif; margin: 0; background: var(--bg); display: flex; }
        
        /* SIDEBAR */
        .sidebar { width: var(--sidebar-width); background: var(--dark-bg); color: #fff; height: 100vh; position: fixed; z-index: 100; }
        .sidebar-brand { padding: 25px; font-size: 24px; font-weight: bold; text-align: center; color: var(--primary-color); border-bottom: 1px solid #3e4b59; }
        .nav-menu { list-style: none; padding: 20px 0; margin: 0; }
        .nav-item { padding: 15px 25px; display: flex; align-items: center; color: #abb4be; text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,0.05); }
        /* Style cho mục đang được chọn */
        .nav-item.active { background: rgba(255,255,255,0.05); color: #fff; border-left-color: #4099ff; }
        .nav-item i { margin-right: 15px; width: 20px; font-size: 18px; }

        /* MAIN AREA */
        .main { margin-left: var(--sidebar-width); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 0 30px; height: 60px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 1px rgba(0,0,0,0.05); }
        .user-profile { display: flex; align-items: center; gap: 10px; color: #555; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
        
        .btn-logout-admin { text-decoration: none; color: #fff; background-color: #ee4d2d; padding: 7px 15px; border-radius: 4px; font-size: 1.3rem; display: flex; align-items: center; gap: 8px; }
        .btn-logout-admin:hover { background-color: #d73211; }

        .content { padding: 30px; flex: 1; }
        .admin-card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .admin-title { margin: 0 0 20px 0; font-size: 1.8rem; color: #333; border-left: 4px solid var(--primary-color); padding-left: 15px; }
    </style>
    @yield('styles')
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">F8-SHOP</div>
        <nav class="nav-menu">
            <a href="{{ url('admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ url('admin/categories') }}" class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Danh mục
            </a>
            <a href="{{ url('admin/products') }}" class="nav-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="{{ url('admin/users') }}" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Khách hàng
            </a>
            <a href="{{ url('admin/orders') }}" class="nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
        </nav>
    </div>

    <div class="main">
        <div class="topbar">
            <span style="font-size: 1.4rem; color: #888;">Trang quản trị hệ thống</span>
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="user-profile">
                    <span>Chào, <b>Hoàng Phúc</b></span>
                    <img src="https://ui-avatars.com/api/?name=Hoang+Phuc&background=4099ff&color=fff" alt="avatar">
                </div>
                <a href="{{ url('logout') }}" class="btn-logout-admin">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>