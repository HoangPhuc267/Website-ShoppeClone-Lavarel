<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // HÀM XỬ LÝ THÊM VÀO GIỎ HÀNG
    public function add(Request $request)
    {
        $userId = Auth::id(); // Lấy ID khách hàng đang đăng nhập
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        // Tìm xem sản phẩm này khách đã bỏ vào giỏ chưa
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Nếu có rồi thì cộng dồn số lượng
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có thì tạo mới
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        // Nếu khách bấm "Mua Ngay", chuyển thẳng sang trang giỏ hàng (sẽ làm ở bước sau)
        if ($request->has('buy_now')) {
            return redirect('/cart'); 
        }

        // Nếu khách bấm "Thêm vào giỏ", giữ nguyên ở trang cũ và thông báo
        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    // HÀM HIỂN THỊ TRANG GIỎ HÀNG
    public function index()
    {
        $userId = Auth::id();

        // Lấy giỏ hàng của khách, nối (JOIN) với bảng Product để lấy tên, giá, ảnh
        $cartItems = CartItem::where('user_id', $userId)
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select('cart_items.*', 'products.name', 'products.price', 'products.image_url')
            ->orderBy('cart_items.id', 'desc')
            ->get();

        return view('cart', compact('cartItems'));
    }

}