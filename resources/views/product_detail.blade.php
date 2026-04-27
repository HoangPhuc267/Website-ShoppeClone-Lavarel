@extends('layouts.app')

@section('title', $product->name . ' - Shopee Clone')

@section('content')
<div class="container" style="margin-top: 20px; margin-bottom: 50px;">
    <div class="grid">
        <div class="product-detail-wrapper">
            <div class="product-detail-image">
                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
            </div>
            <div class="product-detail-info">
                <h1 class="product-detail-title">
                    @if($product->is_mall == 1)
                        <span class="product-detail-mall-badge">Mall</span>
                    @endif
                    {{ $product->name }}
                </h1>

                <div class="product-detail-rating">
                    <span class="product-detail-rating-score">4.9</span> 
                    <span class="product-detail-rating-stars">⭐⭐⭐⭐⭐</span>
                    <span class="product-detail-sold">Đã bán <b>{{ $product->sold_count }}</b></span>
                </div>

                <div class="product-detail-price-box">
                    <span class="product-detail-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    @if($product->discount_percent > 0)
                        <span class="product-detail-discount">GIẢM {{ $product->discount_percent }}%</span>
                    @endif
                </div>

                <div class="product-detail-policy">
                    <div class="product-detail-policy-item">
                        <span class="product-detail-policy-label">Chính sách:</span>
                        <span>Trực tiếp trả hàng trong 15 ngày</span>
                    </div>
                    <div class="product-detail-policy-item">
                        <span class="product-detail-policy-label">Vận chuyển:</span>
                        <span>Miễn phí vận chuyển (Freeship Xtra)</span>
                    </div>
                </div>

                    <div class="product-detail-actions">
                        <form action="/add-to-cart" method="POST">
                            @csrf <input type="hidden" name="product_id" value="{{ $product->id }}">    
                            
                            <div class="product-detail-quantity">
                                <span class="quantity-label">Số Lượng</span>
                                <div class="quantity-control">
                                    <button type="button" class="qnt-btn" onclick="decreaseQnt()">-</button>
                                    <input type="number" name="quantity" id="quantity-input" value="1" min="1" class="qnt-input">
                                    <button type="button" class="qnt-btn" onclick="increaseQnt()">+</button>
                                </div>
                                <span class="quantity-available">{{ rand(100, 1000) }} Sản phẩm có sẵn</span>
                            </div>

                            @if(session('success'))
                                <div style="color: #26aa99; font-size: 1.4rem; margin-bottom: 10px; font-weight: bold;">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif

                            <div class="product-detail-actions">
                                <button type="submit" class="btn-add-cart" name="add_to_cart">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                </button>
                                <button type="submit" class="btn-buy-now" name="buy_now">Mua Ngay</button>
                            </div>
                        </form>

                        <script>
                            function decreaseQnt(){
                                let input = document.getElementById('quantity-input');
                                if (input.value > 1) {
                                    input.value = parseInt(input.value) -1;
                                }
                            }
                            function increaseQnt(){
                                let input = document.getElementById('quantity-input');
                                input.value = parseInt(input.value) + 1;
                            }
                        </script>
                    </div>
                </div>
            </div>  
        </div>

        <div class="product-description-wrapper">
            <div class="product-description-header">MÔ TẢ SẢN PHẨM</div>
            <div class="product-description-content">
                {!! !empty($product->description) ? nl2br(e($product->description)) : 'Đang cập nhật thông tin mô tả sản phẩm này...' !!}
            </div>
        </div>
    </div>
</div>
@endsection