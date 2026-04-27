<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB; // Thêm cái này để gọi trực tiếp Database không cần Model

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy 20 Danh mục bằng Query Builder (Không cần Model Category)
        $categories = DB::table('categories')->limit(20)->get(); 
        
        // 2. Lấy 6 sản phẩm Flash Sale
        $flashSales = Product::where('is_flash_sale', 1)->limit(6)->get();

        // 3. Lấy 8 sản phẩm Shopee Mall
        $mallProducts = Product::where('is_mall', 1)->limit(8)->get();

        // 4. Lấy 6 sản phẩm Top Tìm Kiếm (Bán chạy nhất)
        $topProducts = Product::orderBy('sold_count', 'desc')->limit(6)->get();

        // 5. Lấy Gợi ý hôm nay (Random)
        $dailyDiscovers = Product::where('is_flash_sale', 0)->inRandomOrder()->limit(24)->get();

        // Gửi ĐẦY ĐỦ 5 rổ dữ liệu sang cho View
        return view('home', compact('categories', 'flashSales', 'mallProducts', 'topProducts', 'dailyDiscovers'));
    }
}