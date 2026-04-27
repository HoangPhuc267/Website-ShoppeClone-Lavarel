@extends('admin.layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('styles')
<style>
    /* Form Thêm Mới - Theo style cũ của bạn */
    .add-form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; background: #fffcfb; padding: 20px; border: 1px dashed #ee4d2d; border-radius: 4px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-label { font-size: 1.4rem; font-weight: bold; color: #555; }
    .input-control { padding: 12px; border: 1px solid #ddd; border-radius: 2px; outline: none; font-size: 1.4rem; }
    .input-control:focus { border-color: #ee4d2d; }
    .textarea-control { grid-column: 1 / 3; height: 80px; }
    .btn-add { grid-column: 1 / 3; background: #ee4d2d; color: #fff; border: none; padding: 12px; border-radius: 2px; cursor: pointer; font-weight: bold; font-size: 1.6rem; margin-top: 10px; }

    /* Table Sản phẩm */
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: #f8f8f8; color: #666; text-align: left; padding: 15px; border-bottom: 2px solid #eee; font-size: 1.4rem; text-transform: uppercase; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 1.4rem; vertical-align: middle; }
    
    .prod-img-preview { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; }
    .prod-price-text { color: #ee4d2d; font-weight: bold; }
    /* Nút Thao tác (CSS Mới) */
    .action-cell { display: flex; gap: 8px; align-items: center; }
    .btn-action { text-decoration: none; padding: 6px 12px; border-radius: 3px; font-size: 1.3rem; display: inline-flex; align-items: center; gap: 5px; transition: 0.2s; background: #fff;}
    
    .btn-edit { color: #4099ff; border: 1px solid #4099ff; }
    .btn-edit:hover { background: #4099ff; color: #fff; }
    
    .btn-delete { color: #ff4d4d; border: 1px solid #ff4d4d; }
    .btn-delete:hover { background: #ff4d4d; color: #fff; }
</style>
@endsection

@section('content')
<div class="admin-card">
    <h2 class="admin-title">QUẢN LÝ SẢN PHẨM</h2>

    @if(session('success'))
        <div style="background: #e6f9e6; color: #26aa99; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="/admin/products/store" method="POST" class="add-form" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="input-control" placeholder="VD: Laptop Gaming..." required>
        </div>
        <div class="form-group">
            <label class="form-label">Giá bán (₫)</label>
            <input type="number" name="price" class="input-control" placeholder="VD: 20000000" required>
        </div>
        <div class="form-group">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="input-control" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="input-control" required>
        </div>
        <div class="form-group textarea-control">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="input-control" placeholder="Mô tả ngắn gọn sản phẩm..."></textarea>
        </div>
        <button type="submit" class="btn-add">ĐĂNG SẢN PHẨM</button>
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th width="70">ID</th>
                <th width="80">Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá bán</th>
                <th width="100">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $row)
            <tr>
                <td>#{{ $row->id }}</td>
                <td>
                    <img src="{{ asset($row->image_url) }}" class="prod-img-preview" alt="SP">
                </td>
                <td style="font-weight: bold;">{{ $row->name }}</td>
                <td>
                    <span style="background: #eef8fe; color: #4099ff; padding: 4px 10px; border-radius: 12px; font-size: 1.2rem;">
                        {{ $row->cat_name }}
                    </span>
                </td>
                <td><span class="prod-price-text">{{ number_format($row->price, 0, ',', '.') }}₫</span></td>
                <td class="action-cell">
                    <a href="/admin/products/edit/{{ $row->id }}" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Sửa
                    </a>

                    <a href="/admin/products/delete/{{ $row->id }}" class="btn-action btn-delete" onclick="return confirm('Xóa sản phẩm này?')">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection