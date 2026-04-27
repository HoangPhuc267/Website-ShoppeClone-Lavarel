@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="admin-card">
    <a href="/admin/orders" style="display: inline-block; margin-bottom: 20px; color: #666; text-decoration: none; font-size: 1.4rem;">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>
    
    <h2 class="admin-title">CHI TIẾT ĐƠN HÀNG #ORD-{{ $order->id }}</h2>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px; background: #fafafa; padding: 20px; border-radius: 8px; font-size: 1.4rem;">
        <div>
            <h4 style="color: #ee4d2d;"><i class="fas fa-user"></i> Thông tin khách hàng</h4>
            <p><b>Email:</b> {{ $order->email }}</p>
            <p><b>Phương thức thanh toán:</b> {{ $order->payment_method }}</p>
        </div>
        <div>
            <h4 style="color: #ee4d2d;"><i class="fas fa-shipping-fast"></i> Thời gian & Trạng thái</h4>
            <p><b>Ngày đặt:</b> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
            <p><b>Trạng thái:</b> <b style="color: #fa8c16;">{{ $order->status }}</b></p>
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 1.4rem;">
        <thead>
            <tr style="background: #f8f8f8;">
                <th style="padding: 15px; text-align: left;">Sản phẩm</th>
                <th>Giá bán</th>
                <th>Số lượng</th>
                <th style="text-align: right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $item)
            <tr>
                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                    <img src="{{ asset($item->image_url) }}" width="60" style="border-radius: 4px; border: 1px solid #eee;">
                    <b>{{ $item->name }}</b>
                </td>
                <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                <td>x{{ $item->quantity }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; padding-top: 30px; border-top: 2px solid #eee; margin-top: 20px;">
        <span style="font-size: 1.4rem; color: #888;">Tổng cộng thanh toán:</span><br>
        <span style="font-size: 2.4rem; font-weight: bold; color: #ee4d2d;">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
    </div>
</div>
@endsection