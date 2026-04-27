@extends('admin.layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('styles')
<style>
    .admin-table { width: 100%; border-collapse: collapse; background: #fff; }
    .admin-table th { background: #f8f8f8; padding: 15px; text-align: left; border-bottom: 2px solid #eee; font-size: 1.2rem; color: #888; text-transform: uppercase; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 1.4rem; vertical-align: middle; }

    /* Huy hiệu trạng thái */
    .badge { padding: 5px 12px; border-radius: 15px; font-size: 1.1rem; font-weight: bold; }
    .st-pending { background: #fff7e6; color: #fa8c16; border: 1px solid #ffd591; }
    .st-shipping { background: #e6f7ff; color: #1890ff; border: 1px solid #91d5ff; }
    .st-completed { background: #f6ffed; color: #52c41a; border: 1px solid #b7eb8f; }

    /* Nút Chi tiết (Xanh nhẹ nhàng) */
    .btn-view { color: #4099ff; text-decoration: none; font-weight: bold; padding: 8px 15px; border: 1px solid #4099ff; border-radius: 4px; transition: 0.3s; display: inline-flex; align-items: center; gap: 5px; }
    .btn-view:hover { background: #4099ff; color: #fff; }

    /* Nút Lưu màu cam Shopee */
    .btn-shopee-save { background: #ee4d2d; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1.3rem; transition: 0.3s; }
    .btn-shopee-save:hover { background: #d73211; }

    .status-select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none; min-width: 130px; }
</style>
@endsection

@section('content')
<div class="admin-card">
    <h2 class="admin-title">QUẢN LÝ ĐƠN HÀNG HỆ THỐNG</h2>

    @if(session('success'))
        <div style="background: #e6f9e6; color: #26aa99; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th width="100">Mã ĐH</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th width="120">Chi tiết</th> <th width="250">Cập nhật</th> </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td><b>#ORD-{{ $order->id }}</b></td>
                <td><b>{{ $order->customer_email }}</b></td>
                <td style="color: #ee4d2d; font-weight: bold;">{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                <td>
                    @php
                        $c = 'st-pending';
                        if($order->status == 'Đang giao') $c = 'st-shipping';
                        if($order->status == 'Đã giao') $c = 'st-completed';
                    @endphp
                    <span class="badge {{ $c }}">{{ $order->status }}</span>
                </td>
                
                <td>
                    <a href="/admin/orders/detail/{{ $order->id }}" class="btn-view">
                        <i class="fas fa-eye"></i> Xem
                    </a>
                </td>

                <td>
                    <form action="/admin/orders/update-status/{{ $order->id }}" method="POST" style="display: flex; gap: 8px;">
                        @csrf
                        <select name="new_status" class="status-select">
                            <option value="Chờ xác nhận" {{ $order->status=='Chờ xác nhận'?'selected':'' }}>Chờ xác nhận</option>
                            <option value="Đang giao" {{ $order->status=='Đang giao'?'selected':'' }}>Đang giao</option>
                            <option value="Đã giao" {{ $order->status=='Đã giao'?'selected':'' }}>Đã giao</option>
                            <option value="Đã hủy" {{ $order->status=='Đã hủy'?'selected':'' }}>Đã hủy</option>
                        </select>
                        <button type="submit" class="btn-shopee-save">Lưu</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection