<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 1. Hàm hiển thị Chi tiết sản phẩm
    public function show($id) 
    {
        // findOrFail sẽ tự động báo lỗi 404 nếu khách gõ ID bậy bạ không có trong DB
        $product = Product::findOrFail($id); 
        return view('product_detail', compact('product'));
    }

    // 2. Hàm xử lý Tìm kiếm & Lọc
    public function search(Request $request) 
    {
        // Nhận dữ liệu từ URL (VD: ?keyword=ao&sort=banchay)
        $keyword = $request->input('keyword');
        $category_id = $request->input('category_id');
        $sort = $request->input('sort', 'moinhat');

        // Khởi tạo câu truy vấn
        $query = Product::query();

        // Nếu có gõ từ khóa
        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        // Nếu có bấm vào danh mục
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Xử lý sắp xếp
        if ($sort == 'banchay') {
            $query->orderBy('sold_count', 'desc');
        } elseif ($sort == 'giathap') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'giacao') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'desc'); // Mới nhất
        }

        // Thực thi lấy dữ liệu
        $products = $query->get();

        // Lấy thêm tên danh mục để in ra tiêu đề nếu có
        $categoryName = null;
        if ($category_id) {
            $category = DB::table('categories')->where('id', $category_id)->first();
            $categoryName = $category ? $category->name : '';
        }

        return view('search', compact('products', 'keyword', 'category_id', 'sort', 'categoryName'));
    }
}