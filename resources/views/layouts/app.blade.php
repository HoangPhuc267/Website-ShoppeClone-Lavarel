<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopee Clone - Laravel')</title>
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .header__cart-wrap:hover .header__cart-list {
        display: block !important;
        animation: fadeIn 0.2s ease-in;
    }
    </style>    
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="grid">
                <nav class="header__navbar">
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-qr header__navbar-item-separate">
                            Vào cửa hàng trên ứng dụng F8-Shop
                        </li>
                        <li class="header__navbar-item">
                            <span class="header__navbar-title--no-pointer">Kết Nối</span>
                            <a href="#" class="header__navbar-icon-link"><i class="header__navbar-icon fab fa-facebook"></i></a>
                            <a href="#" class="header__navbar-icon-link"><i class="header__navbar-icon fab fa-instagram"></i></a>
                        </li>
                    </ul>
                    <ul class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-item--has-notify">
                            <a href="/notifications" class="header__navbar-item-link"><i class="header__navbar-icon far fa-bell"></i> Thông Báo</a>
                        </li>
                        <li class="header__navbar-item">
                            <a href="#" class="header__navbar-item-link"><i class="header__navbar-icon far fa-question-circle"></i> Trợ Giúp</a>
                        </li>
                        
                    @guest
                        <li class="header__navbar-item header__navbar-item-strong header__navbar-item-separate">
                            <a href="/register" style="color: white; text-decoration: none;font-size:1.4rem;">Đăng Ký</a>
                        </li>
                        <li class="header__navbar-item header__navbar-item-strong">
                            <a href="/login" style="color: white; text-decoration: none;font-size:1.4rem;">Đăng Nhập</a>
                        </li>
                    @endguest

                    @auth
                         <li class="header__navbar-item header__navbar-item-strong header__navbar-item-separate">
                            <a href="/my-orders" style="color: white; text-decoration: none;font-size:1.4rem; font-weight: 400; display: flex; align-items: center;">
                                <i class="fas fa-clipboard-list" style="margin-right: 5px; font-size: 1.4rem;"></i> Đơn Mua
                            </a>
                        </li>

                        <li class="header__navbar-item header__navbar-item-strong header__navbar-item-separate" style="font-weight: 400;">
                            <a href="/profile" style="color: white; text-decoration: none; display: flex; align-items: center; font-size: 1.4rem;">
                                <i class="fas fa-user-circle" style="margin-right: 5px; font-size: 1.4rem;"></i>
                                {{ Auth::user()->name ?? explode('@', Auth::user()->email)[0] }}
                            </a>
                        </li>
        
                        <li class="header__navbar-item header__navbar-item-strong">
                            <a href="/logout" style="color: white; text-decoration: none;font-size:1.4rem; font-weight: 400;">Đăng Xuất</a>
                        </li>
                    @endauth
                    </ul>
                </nav>

                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="/" class="header__logo-link">
                            <img src="{{ asset('assets/img/OIP (1).jpg') }}" alt="Logo" class="header__logo-img">
                        </a>
                    </div>

                    <form action="/search" method="GET" class="header__search">
                        <div class="header__search-input-wrap">
                            <input type="text" name="keyword" class="header__search-input" placeholder="Tìm trong Shop này" required>
                        </div>
                        <button class="header__search-btn">
                            <i class="header__search-btn-icon fas fa-search"></i>
                        </button>
                    </form>

                    <div class="header__cart">
                        <div class="header__cart-wrap">
                            <a href="/cart" style="color: white; text-decoration: none;">
                                <i class="header__cart-icon fas fa-shopping-cart"></i>
                            </a>

                            @auth
                                @php
                                    $minicartItems = \App\Models\CartItem::where('user_id', Auth::id())
                                        ->join('products', 'cart_items.product_id', '=', 'products.id')
                                        ->select('cart_items.*', 'products.name', 'products.price', 'products.image_url')
                                        ->orderBy('cart_items.id', 'desc')
                                        ->get();
                                @endphp

                                @if($minicartItems->count() > 0)
                                    <span class="header__cart-notice">{{ $minicartItems->count() }}</span>

                                    <div class="header__cart-list" style="width: 400px; cursor: default; display: none;">
                                        <h4 class="header__cart-heading" style="text-align: left; margin: 12px 0 8px 12px; color: #999; font-weight: 400; font-size: 1.4rem;">Sản phẩm mới thêm</h4>
                                        
                                        <ul class="header__cart-list-item" style="padding-left: 0; list-style: none; max-height: 50vh; overflow-y: auto;">
                                            @foreach($minicartItems->take(5) as $item)
                                            <li class="header__cart-item" style="display: flex; align-items: center; padding: 10px 12px;">
                                                <img src="{{ asset($item->image_url) }}" alt="" class="header__cart-img" style="width: 42px; height: 42px; border: 1px solid #E8E8E8; object-fit: cover;">
                                                <div class="header__cart-item-info" style="width: 100%; margin-left: 12px;">
                                                    <div class="header__cart-item-head" style="display: flex; align-items: center; justify-content: space-between;">
                                                        <h5 class="header__cart-item-name" style="font-size: 1.4rem; font-weight: 400; color: #333; margin: 0; flex: 1; padding-right: 16px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-align: left;">{{ $item->name }}</h5>
                                                        <div class="header__cart-item-price-wrap">
                                                            <span class="header__cart-item-price" style="font-size: 1.4rem; color: #ee4d2d;">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                                            <span class="header__cart-item-multiply" style="font-size: 0.9rem; margin: 0 4px; color: #757575;">x</span>
                                                            <span class="header__cart-item-qnt" style="color: #757575; font-size: 1.2rem;">{{ $item->quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>

                                        <div style="text-align: right; margin: 12px;">
                                            <a href="/cart" class="btn btn--primary" style="text-decoration: none; font-size: 1.4rem; padding: 10px 20px; background-color: #ee4d2d; color: white; border-radius: 2px;">Xem Giỏ Hàng</a>
                                        </div>
                                    </div>

                                @else
                                    <div class="header__cart-list header__cart--no-cart">
                                        <img src="{{ asset('assets/img/95974e121862329.Y3JvcCw5MjIsNzIxLDAsMTM5.png') }}" alt="No Cart" class="header__cart-no-cart-img">
                                        <span class="header__cart-list-no-cart-msg">Chưa có sản phẩm nào</span>
                                    </div>
                                @endif

                            @else
                                <div class="header__cart-list header__cart--no-cart">
                                    <img src="{{ asset('assets/img/95974e121862329.Y3JvcCw5MjIsNzIxLDAsMTM5.png') }}" alt="No Cart" class="header__cart-no-cart-img">
                                    <span class="header__cart-list-no-cart-msg">Vui lòng đăng nhập</span>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        <footer class="footer">
            <div class="grid">
                <ul class="footer-policy">
                    <li class="footer-policy-item"><a href="#" class="footer-policy-link">CHÍNH SÁCH BẢO MẬT</a></li>
                    <li class="footer-policy-item"><a href="#" class="footer-policy-link">QUY CHẾ HOẠT ĐỘNG</a></li>
                    <li class="footer-policy-item"><a href="#" class="footer-policy-link">CHÍNH SÁCH VẬN CHUYỂN</a></li>
                    <li class="footer-policy-item"><a href="#" class="footer-policy-link">CHÍNH SÁCH TRẢ HÀNG</a></li>
                </ul>
                <div class="footer-info">
                    <p class="footer-company">Công ty TNHH Shopee Clone</p>
                    <p>© 2026 - Bản quyền thuộc về F8-Shopee</p>
                </div>
            </div>
        </footer>
    </div>

    <div class="modal" id="modal">
        <div class="modal__overlay"></div>
        <div class="modal__body">
            <div class="modal__inner">
                <form class="auth-form" id="register-form" style="background: white; padding: 20px; border-radius: 5px;">
                    <h3>Tính năng Đăng ký đang được chuyển sang Laravel...</h3>
                    <button type="button" class="btn btn--normal auth-form__controls-back">Đóng</button>
                </form>
                <form class="auth-form" id="login-form" style="display: none; background: white; padding: 20px; border-radius: 5px;">
                    <h3>Tính năng Đăng nhập đang được chuyển sang Laravel...</h3>
                    <button type="button" class="btn btn--normal auth-form__controls-back">Đóng</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('main.js') }}"></script> 
</body>
</html>