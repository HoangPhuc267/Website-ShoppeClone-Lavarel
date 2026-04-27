<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn Mua - Shopee</title>
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

        /* Nội dung Phải */
        .main-content { flex: 1; }
        .tabs { display: flex; background: #fff; margin-bottom: 15px; border-radius: 2px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); }
        .tab-item { flex: 1; text-align: center; padding: 15px 0; font-size: 1.4rem; color: #222; cursor: pointer; transition: 0.2s; border-bottom: 2px solid transparent;}
        .tab-item:hover { color: #ee4d2d; }
        .tab-item.active { color: #ee4d2d; border-bottom-color: #ee4d2d; }

        /* Box Đơn hàng */
        .order-card { background: #fff; border-radius: 2px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); margin-bottom: 15px; }
        .order-header { padding: 15px 24px; border-bottom: 1px solid #e8e8e8; display: flex; justify-content: space-between; align-items: center; }
        .shop-name { font-size: 1.4rem; font-weight: bold; color: #333; }
        .order-status { font-size: 1.4rem; color: #26aa99; text-transform: uppercase; }
        
        .order-item { display: flex; padding: 15px 24px; border-bottom: 1px solid #f5f5f5; }
        .order-item img { width: 80px; height: 80px; object-fit: cover; border: 1px solid #e1e1e1; margin-right: 15px; }
        .item-info { flex: 1; }
        .item-name { font-size: 1.4rem; color: #222; margin-bottom: 5px; }
        .item-qty { font-size: 1.2rem; color: #888; }
        .item-price { font-size: 1.4rem; color: #ee4d2d; }

        .order-footer { background: #fffcf5; padding: 24px; display: flex; justify-content: space-between; align-items: center; }
        .total-text { font-size: 1.4rem; color: #222; }
        .total-price { font-size: 2.4rem; color: #ee4d2d; margin-left: 10px; }
        .btn-repurchase { background: #ee4d2d; color: #fff; padding: 10px 30px; font-size: 1.4rem; text-decoration: none; border-radius: 2px; transition: 0.2s; }
        .btn-repurchase:hover { background: #f05d40; }
        
        .empty-order { text-align: center; padding: 100px 0; background: #fff; font-size: 1.6rem; color: #888;}
    </style>
</head>
<body>

    <header class="cart-header">
        <div class="cart-header-inner">
            <a href="/" class="cart-brand">
                <i class="fas fa-shopping-bag cart-logo"></i>
                <span class="cart-title">Đơn Mua</span>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <div class="user-avatar"><i class="fas fa-user"></i></div>
                <div class="user-name">{{ explode('@', Auth::user()->email)[0] }}</div>
            </div>
            <a href="/profile" class="menu-item"><i class="far fa-user-circle"></i> Tài khoản của tôi</a>
            <a href="#" class="menu-item active"><i class="fas fa-clipboard-list" style="color: #ee4d2d;"></i> Đơn Mua</a>
            <a href="#" class="menu-item"><i class="far fa-bell"></i> Thông báo</a>
        </div>

        <div class="main-content">
            <div class="tabs">
                <a href="/my-orders?status=all" class="tab-item {{ $statusFilter == 'all' ? 'active' : '' }}" style="text-decoration: none;">Tất cả</a>
                <a href="/my-orders?status=cho-xac-nhan" class="tab-item {{ $statusFilter == 'cho-xac-nhan' ? 'active' : '' }}" style="text-decoration: none;">Chờ xác nhận</a>
                <a href="/my-orders?status=da-giao" class="tab-item {{ $statusFilter == 'da-giao' ? 'active' : '' }}" style="text-decoration: none;">Đã giao</a>
                <a href="/my-orders?status=da-huy" class="tab-item {{ $statusFilter == 'da-huy' ? 'active' : '' }}" style="text-decoration: none;">Đã hủy</a>
            </div>

            @if($orders->count() > 0)
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="shop-name"><i class="fas fa-store"></i> F8-Shopee Mall</div>
                        <div class="order-status">
                            <i class="fas fa-truck"></i> {{ $order->status }}
                            <span style="color: #888; border-left: 1px solid #ccc; margin-left: 10px; padding-left: 10px; font-size: 1.2rem;">Mã: #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>

                    @foreach($order->items as $item)
                    <div class="order-item">
                        <img src="{{ asset($item->image_url) }}" alt="sp">
                        <div class="item-info">
                            <div class="item-name">{{ $item->name }}</div>
                            <div class="item-qty">x{{ $item->quantity }}</div>
                        </div>
                        <div class="item-price">{{ number_format($item->price, 0, ',', '.') }}đ</div>
                    </div>
                    @endforeach

                    <div class="order-footer">
                        <div>
                            <span style="font-size: 1.2rem; color: #888;">Phương thức: {{ $order->payment_method }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div class="total-text">Thành tiền: <span class="total-price">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span></div>
                            <a href="/" class="btn-repurchase">Mua Lại</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-order">
                    <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/assets/5fafbb923393b712b96488590b8f781f.png" style="width: 100px; opacity: 0.5; margin-bottom: 15px;">
                    <br>Chưa có đơn hàng
                </div>
            @endif
        </div>
    </div>

</body>
</html>