<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng - Shopee</title>
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif; }
        .cart-header { background: #fff; padding: 25px 0; border-bottom: 1px solid rgba(0,0,0,.09); margin-bottom: 20px;}
        .cart-header-inner { display: flex; justify-content: space-between; align-items: center; width: 1200px; margin: 0 auto; }
        .cart-brand { display: flex; align-items: flex-end; text-decoration: none; }
        .cart-logo { color: #ee4d2d; font-size: 3rem; font-weight: bold; margin-right: 15px; }
        .cart-title { font-size: 2rem; color: #ee4d2d; border-left: 1px solid #ee4d2d; padding-left: 15px; line-height: 1.2; }
        .cart-search-bar { display: flex; width: 400px; border: 2px solid #ee4d2d; border-radius: 2px; }
        .cart-search-bar input { flex: 1; border: none; padding: 10px 15px; outline: none; }
        .cart-search-bar button { background: #ee4d2d; border: none; color: #fff; padding: 0 25px; cursor: pointer; }
        .container { width: 1200px; margin: 0 auto; }
        .cart-labels { display: flex; background: #fff; padding: 15px 20px; border-radius: 3px; margin-bottom: 15px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); color: #888; font-size: 1.4rem; align-items: center; }
        .col-checkbox { width: 5%; display: flex; justify-content: center; }
        .col-product { width: 45%; }
        .col-price { width: 15%; text-align: center; }
        .col-qty { width: 15%; text-align: center; }
        .col-total { width: 10%; text-align: center; }
        .col-action { width: 10%; text-align: center; }
        .cart-item { display: flex; background: #fff; padding: 20px; margin-bottom: 15px; border-radius: 3px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); align-items: center; }
        .c-img-name { display: flex; align-items: center; gap: 10px; }
        .c-img-name img { width: 80px; height: 80px; border: 1px solid #e1e1e1; object-fit: cover; }
        .c-name { font-size: 1.4rem; color: #333; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .c-price-text { font-size: 1.4rem; color: #333; }
        .c-total-text { font-size: 1.4rem; color: #ee4d2d; }
        .c-action-btn { color: #333; text-decoration: none; font-size: 1.4rem; border: none; background: transparent; cursor: pointer;}
        .c-action-btn:hover { color: #ee4d2d; }
        .qty-control { display: flex; border: 1px solid #e8e8e8; border-radius: 2px; width: 100px; margin: 0 auto; }
        .qty-btn { width: 32px; height: 32px; background: #fff; border: none; cursor: pointer; font-size: 1.6rem; color: #666; display: flex; align-items: center; justify-content: center; outline: none; }
        .qty-input { width: 36px; height: 32px; border-top: none; border-bottom: none; border-left: 1px solid #e8e8e8; border-right: 1px solid #e8e8e8; text-align: center; font-size: 1.4rem; outline: none; }
        .cart-bottom-bar { position: sticky; bottom: 0; background: #fff; display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; box-shadow: 0 -2px 4px rgba(0,0,0,.05); z-index: 100; border-top: 1px dashed #e8e8e8; margin-top: 20px;}
        .c-bottom-left { display: flex; align-items: center; gap: 20px; font-size: 1.4rem; color: #333; }
        .c-bottom-right { display: flex; align-items: center; gap: 20px; }
        .total-label { font-size: 1.6rem; color: #333; }
        .total-price-display { font-size: 2.8rem; color: #ee4d2d; font-weight: normal; margin-left: 10px; }
        .btn-checkout { background: #ee4d2d; color: #fff; border: none; padding: 15px 45px; font-size: 1.6rem; cursor: pointer; border-radius: 2px; font-weight: 300; transition: 0.2s;}
        .btn-checkout:hover { background: #f05d40; }
        input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: #ee4d2d; }
    </style>
</head>
<body>

    <header class="cart-header">
        <div class="cart-header-inner">
            <a href="/" class="cart-brand">
                <i class="fas fa-shopping-bag cart-logo"></i>
                <span class="cart-title">Giỏ Hàng</span>
            </a>
            <div class="cart-search-bar">
                <input type="text" placeholder="Siêu Rẻ - Chỉ Từ 1.000Đ">
                <button><i class="fas fa-search"></i></button>
            </div>
        </div>
    </header>

    <div class="container">
        @if(session('error'))
            <div style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 20px; text-align: center; font-size: 1.4rem;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif
        <form action="/checkout" method="POST" id="cartForm">
            @csrf
            <div class="cart-labels">
                <div class="col-checkbox"><input type="checkbox" id="selectAll"></div>
                <div class="col-product">Sản Phẩm</div>
                <div class="col-price">Đơn Giá</div>
                <div class="col-qty">Số Lượng</div>
                <div class="col-total">Số Tiền</div>
                <div class="col-action">Thao Tác</div>
            </div>

            @if ($cartItems->count() > 0)
                @foreach ($cartItems as $item)
                <div class="cart-item">
                    <div class="col-checkbox">
                        <input type="checkbox" class="item-checkbox" name="selected_carts[]" value="{{ $item->id }}" data-price="{{ $item->price }}">
                    </div>
                    
                    <div class="col-product c-img-name">
                        <img src="{{ asset($item->image_url) }}" alt="SP">
                        <span class="c-name">{{ $item->name }}</span>
                    </div>
                    
                    <div class="col-price c-price-text">{{ number_format($item->price, 0, ',', '.') }}đ</div>
                    
                    <div class="col-qty">
                        <div class="qty-control">
                            <button type="button" class="qty-btn btn-minus">-</button>
                            <input type="number" class="qty-input" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1">
                            <button type="button" class="qty-btn btn-plus">+</button>
                        </div>
                    </div>
                    
                    <div class="col-total c-total-text item-total-price">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                    </div>
                    
                    <div class="col-action">
                        <button type="button" class="c-action-btn" onclick="alert('Chức năng xóa đang được nâng cấp!')">Xóa</button>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 100px 0; background: #fff; margin-bottom: 20px;">
                    <p style="font-size: 1.6rem; color: #999;">Giỏ hàng của bạn còn trống</p>
                </div>
            @endif

            @if ($cartItems->count() > 0)
            <div class="cart-bottom-bar">
                <div class="c-bottom-left">
                    <input type="checkbox" id="selectAllBottom">
                    <label for="selectAllBottom" style="cursor: pointer;">Chọn Tất Cả</label>
                    <span style="margin-left: 20px; color: #ee4d2d; cursor: pointer;">Lưu vào mục Đã thích</span>
                </div>
                
                <div class="c-bottom-right">
                    <div class="total-label">
                        Tổng thanh toán (<span id="totalCountDisplay">0</span> Sản phẩm): 
                        <span class="total-price-display" id="totalPriceDisplay">0đ</span>
                    </div>
                    <button type="submit" class="btn-checkout">Mua Hàng</button>
                </div>
            </div>
            @endif

        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllTop = document.getElementById('selectAll');
            const selectAllBottom = document.getElementById('selectAllBottom');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            
            function toggleSelectAll(checked) {
                if(selectAllTop) selectAllTop.checked = checked;
                if(selectAllBottom) selectAllBottom.checked = checked;
                itemCheckboxes.forEach(cb => cb.checked = checked);
                calculateTotal();
            }
            if(selectAllTop) selectAllTop.addEventListener('change', (e) => toggleSelectAll(e.target.checked));
            if(selectAllBottom) selectAllBottom.addEventListener('change', (e) => toggleSelectAll(e.target.checked));

            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    const allChecked = Array.from(itemCheckboxes).every(i => i.checked);
                    if(selectAllTop) selectAllTop.checked = allChecked;
                    if(selectAllBottom) selectAllBottom.checked = allChecked;
                    calculateTotal();
                });
            });

            const qtyControls = document.querySelectorAll('.qty-control');
            qtyControls.forEach(control => {
                const btnMinus = control.querySelector('.btn-minus');
                const btnPlus = control.querySelector('.btn-plus');
                const input = control.querySelector('.qty-input');
                const row = control.closest('.cart-item');
                const price = parseInt(row.querySelector('.item-checkbox').dataset.price);
                const totalDisplay = row.querySelector('.item-total-price');

                btnMinus.addEventListener('click', () => {
                    if (input.value > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateRowTotal();
                    }
                });

                btnPlus.addEventListener('click', () => {
                    input.value = parseInt(input.value) + 1;
                    updateRowTotal();
                });

                input.addEventListener('change', () => {
                    if(input.value < 1) input.value = 1;
                    updateRowTotal();
                });

                function updateRowTotal() {
                    const newTotal = price * parseInt(input.value);
                    totalDisplay.innerText = newTotal.toLocaleString('vi-VN') + 'đ';
                    calculateTotal(); 
                }
            });

            function calculateTotal() {
                let totalAmount = 0;
                let totalCount = 0;

                itemCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        const row = cb.closest('.cart-item');
                        const price = parseInt(cb.dataset.price);
                        const qty = parseInt(row.querySelector('.qty-input').value);
                        totalAmount += (price * qty);
                        totalCount++;
                    }
                });

                document.getElementById('totalPriceDisplay').innerText = totalAmount.toLocaleString('vi-VN') + 'đ';
                document.getElementById('totalCountDisplay').innerText = totalCount;
            }
        });
    </script>
</body>
</html>