<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm Shopee</title>
    <style>
        .product-item { border: 1px solid #ccc; padding: 15px; margin: 10px; width: 250px; float: left; }
        .price { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>🛒 Cửa hàng của Phúc</h1>

    @foreach($products as $product)
        <div class="product-item">
            <h3>
                <a href="/products/{{ $product->id }}">{{ $product->name }}</a>

            </h3>
            
            <p class="price">{{ number_format($product->price) }} VNĐ</p>
            
            <p>Giảm giá: {{ $product->discount_percent }}%</p>
        </div>
    @endforeach

</body>
</html>