<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Báo - Shopee</title>
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .cart-header { background: #fff; padding: 25px 0; border-bottom: 1px solid rgba(0,0,0,.09); margin-bottom: 20px;}
        .cart-header-inner { display: flex; justify-content: space-between; align-items: center; width: 1200px; margin: 0 auto; }
        .cart-brand { display: flex; align-items: flex-end; text-decoration: none; }
        .cart-logo { color: #ee4d2d; font-size: 3rem; font-weight: bold; margin-right: 15px; }
        .cart-title { font-size: 2rem; color: #ee4d2d; border-left: 1px solid #ee4d2d; padding-left: 15px; line-height: 1.2; }
        
        .container { width: 1200px; margin: 0 auto; display: flex; gap: 20px; padding-bottom: 50px;}
        
        /* Menu Trái */
        .sidebar { width: 180px; }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid #e8e8e8; }
        .user-avatar { width: 50px; height: 50px; border-radius: 50%; background: #ccc; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; }
        .user-name { font-size: 1.4rem; font-weight: bold; color: #333; }
        .menu-item { display: block; font-size: 1.4rem; color: #222; text-decoration: none; margin-bottom: 15px; transition: 0.2s;}
        .menu-item:hover, .menu-item.active { color: #ee4d2d; }
        .menu-item i { width: 20px; text-align: center; margin-right: 8px; color: #1a71ff; }
        .menu-item.active i { color: #ee4d2d; }

        /* Nội dung Phải: Danh sách thông báo */
        .main-content { flex: 1; background: #fff; border-radius: 2px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); }
        .notify-header { display: flex; justify-content: flex-end; padding: 15px 20px; border-bottom: 1px solid #e8e8e8; }
        .mark-read-btn { color: #888; font-size: 1.4rem; text-decoration: none; cursor: pointer; }
        .mark-read-btn:hover { color: #ee4d2d; }

        .notify-list { list-style: none; padding: 0; margin: 0; }
        .notify-item { display: flex; padding: 20px; border-bottom: 1px solid #f5f5f5; text-decoration: none; transition: 0.2s; }
        .notify-item:hover { background: #fafafa; }
        
        /* Đổi màu nền cho thông báo chưa đọc */
        .notify-item.unread { background: #fff8f6; }
        .notify-item.unread:hover { background: #fdf3f0; }

        .notify-img { width: 80px; height: 80px; object-fit: contain; margin-right: 20px; }
        .notify-content { flex: 1; }
        .notify-title { font-size: 1.6rem; color: #333; margin: 0 0 8px; font-weight: 500; }
        .notify-desc { font-size: 1.4rem; color: #555; line-height: 1.5; margin: 0 0 10px; }
        .notify-time { font-size: 1.2rem; color: #999; }
        
        .empty-notify { text-align: center; padding: 100px 0; font-size: 1.6rem; color: #888; }
    </style>
</head>
<body>

    <header class="cart-header">
        <div class="cart-header-inner">
            <a href="/" class="cart-brand">
                <i class="fas fa-shopping-bag cart-logo"></i>
                <span class="cart-title">Thông Báo</span>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <div class="user-avatar"><i class="fas fa-user"></i></div>
                <div class="user-name">{{ Auth::user()->name ?? explode('@', Auth::user()->email)[0] }}</div>
            </div>
            <a href="/profile" class="menu-item"><i class="far fa-user-circle"></i> Tài khoản của tôi</a>
            <a href="/my-orders" class="menu-item"><i class="fas fa-clipboard-list"></i> Đơn Mua</a>
            <a href="/notifications" class="menu-item active"><i class="far fa-bell" style="color: #ee4d2d;"></i> Thông báo</a>
        </div>

        <div class="main-content">
            @if($notifications->count() > 0)
                <div class="notify-header">
                    <span class="mark-read-btn">Đánh dấu Đã đọc tất cả</span>
                </div>
                
                <ul class="notify-list">
                    @foreach($notifications as $notify)
                    <a href="#" class="notify-item {{ $notify->is_read == 0 ? 'unread' : '' }}">
                        @if(strpos($notify->title, 'Voucher') !== false)
                            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/0abf8b8a6d967e88c03e.png" class="notify-img">
                        @else
                            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/2f1228221c97a55c2bf9.png" class="notify-img">
                        @endif
                        
                        <div class="notify-content">
                            <h3 class="notify-title">{{ $notify->title }}</h3>
                            <p class="notify-desc">{{ $notify->message }}</p>
                            <span class="notify-time">{{ \Carbon\Carbon::parse($notify->created_at)->format('H:i d/m/Y') }}</span>
                        </div>
                    </a>
                    @endforeach
                </ul>
            @else
                <div class="empty-notify">
                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/fa4e2b534cf81c5d.png" style="width: 100px; opacity: 0.5; margin-bottom: 15px;">
                    <br>Chưa có thông báo nào
                </div>
            @endif
        </div>
    </div>

</body>
</html>