@extends('admin.layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('styles')
<style>
    /* Kế thừa các style từ file cũ của bạn */
    .action-box { display: flex; gap: 10px; margin-bottom: 30px; padding: 20px; background: #fffcfb; border: 1px solid #ffe8e3; border-radius: 4px; }
    .input-text { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 2px; outline: none; font-size: 1.4rem; }
    .input-text:focus { border-color: #ee4d2d; }
    
    .btn { padding: 0 25px; border: none; cursor: pointer; font-weight: bold; border-radius: 2px; font-size: 1.4rem; }
    .btn-add { background: #ee4d2d; color: #fff; }
    .btn-edit { background: #28a745; color: #fff; }

    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: #f8f8f8; color: #666; text-align: left; padding: 15px; border-bottom: 2px solid #eee; font-size: 1.4rem; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 1.4rem; color: #333; }
    
    .qty-container { display: inline-block; width: 90px; text-align: left; }
    .number-part { display: inline-block; width: 30px; text-align: right; font-weight: bold; color: #ee4d2d; margin-right: 5px; }
    
    .btn-action { text-decoration: none; font-size: 1.3rem; padding: 6px 12px; border-radius: 3px; margin-right: 5px; display: inline-block; }
    .btn-del { border: 1px solid #ff4d4d; color: #ff4d4d; }
    .btn-del:hover { background: #ff4d4d; color: #fff; }
    .btn-upd { border: 1px solid #4099ff; color: #4099ff; }
    .btn-upd:hover { background: #4099ff; color: #fff; }
</style>
@endsection

@section('content')
<div class="admin-card">
    <h2 class="admin-title">QUẢN LÝ DANH MỤC SẢN PHẨM</h2>

    @if(session('success'))
        <div style="background: #e6f9e6; color: #26aa99; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background: #fff0f0; color: #ff4d4d; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if(isset($categoryEdit))
        <form action="/admin/categories/update/{{ $categoryEdit->id }}" method="POST" class="action-box">
            @csrf
            <input type="text" name="name" class="input-text" value="{{ $categoryEdit->name }}" required>
            <button type="submit" class="btn btn-edit">CẬP NHẬT</button>
            <a href="/admin/categories" style="line-height: 40px; color: #666; text-decoration: none; font-size: 1.4rem; margin-left: 10px;">Hủy</a>
        </form>
    @else
        <form action="/admin/categories/store" method="POST" class="action-box">
            @csrf
            <input type="text" name="name" class="input-text" placeholder="Nhập tên danh mục mới (VD: Điện tử, Thời trang...)" required>
            <button type="submit" class="btn btn-add">THÊM MỚI</button>
        </form>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th width="100">ID</th>
                <th>Tên danh mục</th>
                <th style="text-align: center;">Số Sản Phẩm</th>
                <th width="250">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $row)
            <tr>
                <td>#{{ $row->id }}</td>
                <td><b>{{ $row->name }}</b></td>
                <td style="text-align: center;">
                    <div class="qty-container">
                        <span class="number-part">{{ $row->product_count }}</span>
                        <span>món</span>
                    </div>
                </td>
                <td>
                    <a href="/admin/categories/edit/{{ $row->id }}" class="btn-action btn-upd"><i class="fas fa-edit"></i> Sửa</a>
                    <a href="/admin/categories/delete/{{ $row->id }}" class="btn-action btn-del" onclick="return confirm('Xóa danh mục này?')"><i class="fas fa-trash"></i> Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection