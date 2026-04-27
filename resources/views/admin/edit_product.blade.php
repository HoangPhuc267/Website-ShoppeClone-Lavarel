@extends('admin.layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="admin-card">
    <h2 class="admin-title">SỬA SẢN PHẨM: {{ $product->name }}</h2>

    <form action="/admin/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data" 
          style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #fffcfb; padding: 20px; border: 1px dashed #4099ff;">
        @csrf
        <div style="display: flex; flex-direction: column; gap: 5px;">
            <label style="font-size: 1.4rem; font-weight: bold;">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ $product->name }}" style="padding: 12px; border: 1px solid #ddd;" required>
        </div>

        <div style="display: flex; flex-direction: column; gap: 5px;">
            <label style="font-size: 1.4rem; font-weight: bold;">Giá bán (₫)</label>
            <input type="number" name="price" value="{{ $product->price }}" style="padding: 12px; border: 1px solid #ddd;" required>
        </div>

        <div style="display: flex; flex-direction: column; gap: 5px;">
            <label style="font-size: 1.4rem; font-weight: bold;">Danh mục</label>
            <select name="category_id" style="padding: 12px; border: 1px solid #ddd;" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; flex-direction: column; gap: 5px;">
            <label style="font-size: 1.4rem; font-weight: bold;">Ảnh sản phẩm (Để trống nếu không đổi)</label>
            <input type="file" name="image" style="padding: 10px; border: 1px solid #ddd;">
            <img src="{{ asset($product->image_url) }}" width="50" style="margin-top: 10px; border-radius: 4px;">
        </div>

        <div style="grid-column: 1 / 3; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-size: 1.4rem; font-weight: bold;">Mô tả</label>
            <textarea name="description" rows="4" style="padding: 12px; border: 1px solid #ddd;">{{ $product->description }}</textarea>
        </div>

        <div style="grid-column: 1 / 3;">
            <button type="submit" style="background: #4099ff; color: #fff; border: none; padding: 12px 25px; border-radius: 2px; cursor: pointer; font-weight: bold;">LƯU THAY ĐỔI</button>
            <a href="/admin/products" style="margin-left: 15px; color: #666; text-decoration: none; font-size: 1.4rem;">Hủy</a>
        </div>
    </form>
</div>
@endsection