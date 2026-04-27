@extends('layouts.app')

@section('title', 'Trang Chủ - Shopee Clone')

@section('content')
<div class="container">
    <div class="grid">

        <div class="banner-container">
            <div class="main-banner vanilla-slider">
                <div class="slider-wrapper" id="sliderWrapper">
                    <img src="{{ asset('assets/img/AnhLon-Banner.jpg') }}" alt="Banner 1">
                    <img src="{{ asset('assets/img/AnhNho-Banner1.jpg') }}" alt="Banner 2">
                    <img src="{{ asset('assets/img/AnhLon-Banner.jpg') }}" alt="Banner 3">
                </div>
                <button class="btn-prev" onclick="prevSlide()">&#10094;</button>
                <button class="btn-next" onclick="nextSlide()">&#10095;</button>
            </div>
            <div class="sub-banners">
                <img src="{{ asset('assets/img/AnhNho-Banner1.jpg') }}" alt="Banner phụ 1">
                <img src="{{ asset('assets/img/AnhNho-Banner1.jpg') }}" alt="Banner phụ 2">
            </div>
        </div>

        <ul class="category-list">
            <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/catetory-banner1.webp" alt="">
                        </div>
                        <span class="category-text">Hàng Quốc Tế</span>
                    </a>
                </li>
                
                <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/category-banner2.webp" alt="">
                        </div>
                        <span class="category-text">Shoppe Xử Lý</span>
                    </a>
                </li>
    
                <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/category-banner3l.webp" alt="">
                        </div>
                        <span class="category-text">Deal Hot Gio Vàng</span>
                    </a>
                </li>
    
                <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/cateory-banner4.webp" alt="">
                        </div>
                        <span class="category-text">Shopee Style</span>
                    </a>
                </li>
    
                <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/cateory-banner5.webp" alt="">
                        </div>
                        <span class="category-text">Khách Hàng Thân Thiết</span>
                    </a>
                </li>
    
                <li class="category-item">
                    <a href="" class="category-link">
                        <div class="category-icon">
                            <img src="./assets/img/cateory-banner6.webp" alt="">
                        </div>
                        <span class="category-text">Mã Giam Gía</span>
                    </a>
                </li>
        </ul>
        
        <div class="home-category-section">
            <div class="hc-header"><h1 class="hc-title">DANH MỤC</h1></div>
            <div class="hc-body">
                <ul class="hc-list">
                    @foreach($categories as $cat)
                        <li class="hc-item">
                            <a href="/search?category_id={{ $cat->id }}" class="hc-link">
                                <div class="hc-img-wrap">
                                    <img src="{{ $cat->image_url ? asset($cat->image_url) : 'https://down-vn.img.susercontent.com/file/687f3967b7c2fe6a134a2c11894eea4b_tn' }}" class="hc-img">
                                </div>
                                <div class="hc-name">{{ $cat->name }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flash-sale-section">
            <div class="fs-header">
                <div class="fs-header-left">
                    <h2 class="fs-title">🔥 FLASH SALE</h2>
                </div>
                <a href="#" class="fs-view-all">Xem tất cả</a>
            </div>
            <ul class="fs-list" id="flash-sale-list">
                @foreach($flashSales as $product)
                    <li class="fs-item">
                        <a href="/product/{{ $product->id }}" class="fs-link">
                            <div class="fs-img-wrap">
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="fs-img">
                                @if($product->discount_percent > 0)
                                    <div class="fs-badge">-{{ $product->discount_percent }}%</div>
                                @endif
                            </div>
                            <div class="fs-info">
                                <div class="fs-price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                <div class="fs-progress">
                                    <div class="fs-progress-bar" style="width: {{ min(($product->sold_count/100)*100, 100) }}%;"></div>
                                    <span class="fs-progress-text">ĐANG BÁN CHẠY</span>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="shopee-mall-section">
            <div class="mall-header">
                <div class="mall-header-left"><h2 class="mall-title">SHOPEE MALL</h2></div>
                <a href="#" class="mall-view-all">Xem tất cả</a>
            </div>
            <div class="mall-content">
                <div class="mall-banner">
                    <img src="{{ asset('assets/img/Sansaledealhot.jpg') }}" alt="Mall" class="mall-banner-img">
                </div>
                <div class="mall-products">
                    @foreach($mallProducts as $product)
                        <a href="/product/{{ $product->id }}" class="mall-item">
                            <div class="mall-item-img-wrap">
                                <img src="{{ asset($product->image_url) }}" class="mall-item-img">
                            </div>
                            <div class="mall-brand-pill">{{ $product->name }}</div>
                            <div class="mall-promo">{{ $product->discount_percent > 0 ? 'Ưu đãi đến ' . $product->discount_percent . '%' : 'Mua là có quà' }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="top-search-section">
            <div class="ts-header"><h2 class="ts-title">TÌM KIẾM HÀNG ĐẦU</h2></div>
            <div class="ts-list">
                @foreach($topProducts as $product)
                    @php 
                        $sold_k = floor($product->sold_count / 1000);
                        $sales_text = $sold_k > 0 ? "Bán " . $sold_k . "k+ / tháng" : "Bán " . $product->sold_count . " / tháng";
                    @endphp
                    <a href="/product/{{ $product->id }}" class="ts-item">
                        <div class="ts-img-wrap">
                            <img src="{{ asset($product->image_url) }}" class="ts-img">
                            <div class="ts-badge-top">TOP</div>
                            <div class="ts-sales-overlay">{{ $sales_text }}</div>
                        </div>
                        <div class="ts-title-text">{{ $product->name }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="daily-discover-section">
            <div class="dd-header"><h1 class="dd-title">GỢI Ý HÔM NAY</h1></div>
            <div class="dd-list">
                @foreach($dailyDiscovers as $product)
                    <a href="/product/{{ $product->id }}" class="dd-item">
                        <div class="dd-img-wrap">
                            <img src="{{ asset($product->image_url) }}" class="dd-img">
                            @if($product->discount_percent > 0)
                                <div class="dd-discount-badge">-{{ $product->discount_percent }}%</div>
                            @endif
                        </div>
                        <div class="dd-info">
                            <div class="dd-name">{{ $product->name }}</div>
                            @if(!empty($product->tag))
                                <div class="dd-tag">{{ $product->tag }}</div>
                            @endif
                            <div class="dd-price-sales">
                                <span class="dd-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                <span class="dd-sales">Đã bán {{ $product->sold_count }}</span>
                            </div>
                        </div>
                        <div class="dd-find-similar">Tìm sản phẩm tương tự</div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection