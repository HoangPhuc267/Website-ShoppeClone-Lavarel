<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán - Shopee</title>
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
        
        .container { width: 1200px; margin: 0 auto; padding-bottom: 50px;}
        
        /* Box Địa chỉ */
        .address-box { background: #fff; border-radius: 3px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); position: relative; padding: 28px 30px 24px; margin-bottom: 20px; }
        .address-box::before { content: ""; height: 3px; width: 100%; position: absolute; top: 0; left: 0; background-image: repeating-linear-gradient(45deg,#6fa6d6,#6fa6d6 33px,transparent 0,transparent 41px,#f18d9b 0,#f18d9b 74px,transparent 0,transparent 82px); }
        .address-title { color: #ee4d2d; font-size: 1.8rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .address-info { font-size: 1.6rem; color: #333; display: flex; align-items: center; gap: 20px; }
        
        /* Box Sản phẩm */
        .product-box { background: #fff; border-radius: 3px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); padding: 24px 30px; margin-bottom: 20px; }
        .table-header { display: flex; font-size: 1.4rem; color: #bbb; margin-bottom: 15px; }
        .product-row { display: flex; align-items: center; padding: 15px 0; border-top: 1px dashed #e8e8e8; }
        .col-name { flex: 1; display: flex; align-items: center; gap: 15px; font-size: 1.4rem; color: #222; }
        .col-name img { width: 40px; height: 40px; object-fit: cover; border: 1px solid #eee; }
        .col-type { width: 15%; font-size: 1.4rem; color: #888; text-align: center; }
        .col-price, .col-qty, .col-total { width: 15%; font-size: 1.4rem; text-align: center; }
        .col-total { color: #ee4d2d; }
        /* CSS cho các nút chọn Phương thức thanh toán */
        .payment-options { display: flex; gap: 15px; }
        .btn-payment { background: #fff; border: 1px solid #ccc; padding: 10px 20px; border-radius: 2px; cursor: pointer; font-size: 1.4rem; color: #333; transition: 0.2s; position: relative; overflow: hidden;}
        .btn-payment:hover { border-color: #ee4d2d; }
        .btn-payment.active { border-color: #ee4d2d; color: #ee4d2d; font-weight: bold; }
        /* Dấu tick nhỏ ở góc khi được chọn */
        .btn-payment.active::after { content: "✓"; position: absolute; bottom: 0; right: 0; background: #ee4d2d; color: #fff; font-size: 10px; padding: 2px 4px; border-top-left-radius: 4px; }
        
        /* Box Phương thức & Tổng kết */
        .payment-box { background: #fff; border-radius: 3px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); padding: 0; margin-bottom: 20px; }
        .payment-method { padding: 30px; border-bottom: 1px dashed #e8e8e8; display: flex; align-items: center; }
        .payment-title { font-size: 1.8rem; color: #222; width: 250px; }
        .payment-tag { border: 1px solid #ee4d2d; color: #ee4d2d; padding: 5px 15px; font-size: 1.4rem; border-radius: 2px; }
        
        .checkout-summary { background: #fffcf5; padding: 20px 30px; border-top: 1px dashed #e8e8e8; display: flex; justify-content: flex-end; }
        .summary-content { width: 400px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 1.4rem; color: #555; }
        .summary-total { display: flex; justify-content: space-between; margin-bottom: 25px; align-items: center; border-top: 1px dashed #e8e8e8; padding-top: 15px;}
        .total-label { font-size: 1.6rem; color: #333; }
        .total-amount { font-size: 2.8rem; color: #ee4d2d; }
        .btn-place-order { background: #ee4d2d; color: #fff; border: none; padding: 13px 36px; font-size: 1.6rem; cursor: pointer; border-radius: 2px; width: 100%; box-shadow: 0 1px 1px 0 rgba(0,0,0,.09); transition: 0.2s;}
        .btn-place-order:hover { background: #f05d40; }
    </style>
</head>
<body>

    <header class="cart-header">
        <div class="cart-header-inner">
            <a href="/" class="cart-brand">
                <i class="fas fa-shopping-bag cart-logo"></i>
                <span class="cart-title">Thanh Toán</span>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="address-box">
            <div class="address-title"><i class="fas fa-map-marker-alt"></i> Địa Chỉ Nhận Hàng</div>
            <div class="address-info">
                <b>{{ explode('@', Auth::user()->email)[0] }} (+84) 987 654 321</b>
                <span>Học Viện Công Nghệ Bưu Chính Viễn Thông (PTIT), Quận Hà Đông, Hà Nội</span>
                <a href="#" style="color: #05a; font-size: 1.4rem; text-decoration: none; margin-left: 20px;">Thay đổi</a>
            </div>
        </div>

        <div class="product-box">
            <div class="table-header">
                <div style="flex: 1; color: #222; font-size: 1.8rem;">Sản phẩm</div>
                <div class="col-price">Đơn giá</div>
                <div class="col-qty">Số lượng</div>
                <div class="col-total">Thành tiền</div>
            </div>

            @foreach($checkoutItems as $item)
            <div class="product-row">
                <div class="col-name">
                    <img src="{{ asset($item->image_url) }}" alt="">
                    <span>{{ $item->name }}</span>
                </div>
                <div class="col-price">{{ number_format($item->price, 0, ',', '.') }}đ</div>
                <div class="col-qty">{{ $item->quantity }}</div>
                <div class="col-total">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</div>
            </div>
            @endforeach
            
            <div style="padding-top: 20px; display: flex; align-items: center; font-size: 1.4rem; border-top: 1px dashed #e8e8e8; margin-top: 20px;">
                <span style="color: #222; width: 100px;">Lời nhắn:</span>
                <input type="text" placeholder="Lưu ý cho Người bán..." style="flex: 1; padding: 8px; border: 1px solid #ccc; outline: none; border-radius: 2px;">
            </div>
        </div>

        <form action="/place-order" method="POST">
            @csrf
            
            @foreach($selectedCartIds as $id)
                <input type="hidden" name="cart_ids[]" value="{{ $id }}">
            @endforeach
            
            <div class="payment-box">
                <div class="payment-method">
                    <div class="payment-title">Phương thức thanh toán</div>
                    
                    <div class="payment-options">
                        <button type="button" class="btn-payment active" data-method="COD">Thanh toán khi nhận hàng (COD)</button>
                        <button type="button" class="btn-payment" data-method="MOMO">Ví ShopeePay / MoMo</button>
                        <button type="button" class="btn-payment" data-method="VNPAY">Thẻ Tín dụng/Ghi nợ</button>
                    </div>

                    <input type="hidden" name="payment_method" id="input_payment_method" value="COD">
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const paymentBtns = document.querySelectorAll('.btn-payment');
                        const paymentInput = document.getElementById('input_payment_method');

                        paymentBtns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                // 1. Xóa class 'active' khỏi tất cả các nút
                                paymentBtns.forEach(b => b.classList.remove('active'));
                                
                                // 2. Thêm class 'active' cho nút vừa được bấm
                                this.classList.add('active');
                                
                                // 3. Cập nhật giá trị vào thẻ input ẩn để gửi lên Database
                                paymentInput.value = this.getAttribute('data-method');
                            });
                        });
                    });
                </script>
                
                <div class="checkout-summary">
                    <div class="summary-content">
                        <div class="summary-row">
                            <span>Tổng tiền hàng</span>
                            <span>{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Phí vận chuyển</span>
                            <span>30.000đ</span>
                        </div>
                        <div class="summary-total">
                            <span class="total-label">Tổng thanh toán:</span>
                            <span class="total-amount">{{ number_format($totalAmount + 30000, 0, ',', '.') }}đ</span>
                        </div>
                        <button type="submit" class="btn-place-order">Đặt Hàng</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>
</html>