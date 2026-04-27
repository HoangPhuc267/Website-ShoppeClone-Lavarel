<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công - Shopee</title>
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .receipt-container { width: 800px; margin: 50px auto; background: #fff; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; padding: 50px 30px; border-top: 5px solid #26aa99;}
        .icon-success { font-size: 80px; color: #26aa99; margin-bottom: 20px; }
        .receipt-title { font-size: 2.8rem; color: #333; margin-bottom: 10px; }
        .receipt-desc { font-size: 1.6rem; color: #777; margin-bottom: 40px; }
        
        .receipt-details { background: #fafafa; border: 1px dashed #e1e1e1; padding: 20px; border-radius: 4px; text-align: left; width: 550px; margin: 0 auto 40px; }
        .detail-row { display: flex; justify-content: space-between; font-size: 1.5rem; color: #555; margin-bottom: 15px; border-bottom: 1px dotted #eee; padding-bottom: 10px;}
        .detail-row:last-child { border: none; margin-bottom: 0; padding-bottom: 0; font-weight: bold; color: #ee4d2d;}
        
        .action-btns { display: flex; justify-content: center; gap: 20px; }
        .btn { padding: 12px 30px; font-size: 1.6rem; text-decoration: none; border-radius: 2px; transition: 0.2s; cursor: pointer; border: 1px solid transparent;}
        .btn-home { background: #fff; color: #555; border-color: #ccc; }
        .btn-home:hover { background: #f8f8f8; }
        .btn-orders { background: #ee4d2d; color: #fff; }
        .btn-orders:hover { background: #f05d40; }
    </style>
</head>
<body>

    <div class="receipt-container">
        <i class="fas fa-check-circle icon-success"></i>
        <h1 class="receipt-title">Đặt Hàng Thành Công!</h1>
        <p class="receipt-desc">Cảm ơn bạn đã mua sắm tại F8-Shopee. Đơn hàng của bạn đang được xử lý.</p>

        <div style="width: 550px; margin: 0 auto 30px; text-align: left; border: 1px solid #e1e1e1; border-radius: 4px; overflow: hidden; background: #fff;">
            <div style="background: #fafafa; padding: 12px 15px; border-bottom: 1px solid #e1e1e1; font-weight: bold; color: #555; font-size: 1.4rem;">
                <i class="fas fa-box-open" style="margin-right: 5px; color: #ee4d2d;"></i> Sản phẩm đã mua
            </div>
            <div style="max-height: 300px; overflow-y: auto; padding: 0 15px;">
                @foreach($orderItems as $item)
                <div style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px dashed #eee;">
                    <img src="{{ asset($item->image_url) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 2px; border: 1px solid #eee;">
                    <div style="flex: 1; margin-left: 15px;">
                        <div style="font-size: 1.4rem; color: #333; margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->name }}
                        </div>
                        <div style="font-size: 1.2rem; color: #888;">Số lượng: {{ $item->quantity }}</div>
                    </div>
                    <div style="font-size: 1.4rem; color: #333; font-weight: 500;">
                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="receipt-details">
            <div class="detail-row">
                <span>Mã đơn hàng:</span>
                <span>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span>Phương thức thanh toán:</span>
                <span>{{ $order->payment_method }}</span>
            </div>
            <div class="detail-row">
                <span>Trạng thái:</span>
                <span style="color: #26aa99;">{{ $order->status }}</span>
            </div>
            <div class="detail-row">
                <span>Tổng thanh toán:</span>
                <span style="font-size: 2rem;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
            </div>
        </div>

        <div class="action-btns">
            <a href="/" class="btn btn-home">Tiếp tục mua sắm</a>
            <a href="/my-orders" class="btn btn-