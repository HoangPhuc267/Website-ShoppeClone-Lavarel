@extends('layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="grid">
        <div class="daily-discover-section">
            
            <h1 class="dd-header">
                @if($keyword)
                    KẾT QUẢ TÌM KIẾM CHO: '{{ $keyword }}'
                @elseif($category_id)
                    DANH MỤC: {{ mb_strtoupper($categoryName, 'UTF-8') }}
                @else
                    TẤT CẢ SẢN PHẨM
                @endif
            </h1>
            
            <div class="home-filter" style="display: flex; align-items: center; background-color: rgba(0, 0, 0, 0.04); padding: 12px 22px; border-radius: 2px; margin-bottom: 20px;">
                <span class="home-filter__label" style="font-size: 1.4rem; color: #555; margin-right: 16px;">Sắp xếp theo</span>
                
                @php 
                    $url_params = "";
                    if($keyword) $url_params .= "&keyword=" . urlencode($keyword);
                    if($category_id) $url_params .= "&category_id=" . $category_id;
                @endphp

                <a href="/search?sort=moinhat{{ $url_params }}" class="btn {{ $sort=='moinhat' ? 'btn--primary' : 'btn--normal' }}" style="margin-right: 10px; min-width: 90px; text-decoration: none;">Mới nhất</a>
                <a href="/search?sort=banchay{{ $url_params }}" class="btn {{ $sort=='banchay' ? 'btn--primary' : 'btn--normal' }}" style="margin-right: 10px; min-width: 90px; text-decoration: none;">Bán chạy</a>

                <div class="select-input" style="min-width: 200px; height: 34px; padding: 0 12px; border-radius: 2px; background-color: #fff; display: flex; align-items: center; justify-content: space-between; position: relative; cursor: pointer;">
                    <span class="select-input__label" style="font-size: 1.4rem;">
                        @if($sort == 'giathap') Giá: Thấp đến Cao
                        @elseif($sort == 'giacao') Giá: Cao đến Thấp
                        @else Giá
                        @endif
                    </span>
                    <i class="select-input__icon fas fa-angle-down" style="font-size: 1.4rem; color: rgb(131, 131, 131);"></i>
    
                    <ul class="select-input__list" style="position: absolute; left: 0; right: 0; top: calc(100% + 1px); border-radius: 2px; background-color: #fff; padding: 8px 16px; list-style: none; display: none; box-shadow: 0 1px 2px #e0e0e0; z-index: 1;">
                        <li class="select-input__item" style="padding: 8px 0;">
                            <a href="/search?sort=giathap{{ $url_params }}" class="select-input__link" style="font-size: 1.4rem; color: #333; text-decoration: none; display: block;">Giá: Thấp đến Cao</a>
                        </li>
                        <li class="select-input__item" style="padding: 8px 0;">
                            <a href="/search?sort=giacao{{ $url_params }}" class="select-input__link" style="font-size: 1.4rem; color: #333; text-decoration: none; display: block;">Giá: Cao đến Thấp</a>
                        </li>
                    </ul>
                </div>
            </div>

            <style>
                .select-input:hover .select-input__list { display: block !important; }
                .select-input__link:hover { color: #ee4d2d !important; }
            </style>

            <div class="dd-list">
                @if($products->count() > 0)
                    @foreach($products as $product)
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
                @else
                    <div style='width: 100%; text-align: center; padding: 50px 0;'>
                        <img src='https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/search/a60759ad1dabe909c46a817ecbf71878.png' style='width: 130px; margin-bottom: 20px;'>
                        <p style='font-size: 1.6rem; color: #999;'>Rất tiếc, không tìm thấy sản phẩm nào.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>   
@endsection