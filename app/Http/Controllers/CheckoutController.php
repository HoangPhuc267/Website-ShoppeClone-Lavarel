<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách ID các giỏ hàng được tích chọn
        $selectedCartIds = $request->input('selected_carts');

        // Nếu khách chưa chọn món nào mà bấm Mua Hàng -> Đuổi về
        if (!$selectedCartIds || count($selectedCartIds) == 0) {
            return back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán!');
        }

        // Trước khi tính tiền, cập nhật lại số lượng mới nhất nhỡ khách vừa bấm nút + / -
        foreach ($selectedCartIds as $cartId) {
            $qty = $request->input('quantities.'.$cartId);
            if ($qty) {
                CartItem::where('id', $cartId)->where('user_id', Auth::id())->update(['quantity' => $qty]);
            }
        }

        // Lấy thông tin chi tiết các món hàng đã chọn để in ra hóa đơn
        $checkoutItems = CartItem::whereIn('cart_items.id', $selectedCartIds)
            ->where('cart_items.user_id', Auth::id())
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select('cart_items.*', 'products.name', 'products.price', 'products.image_url')
            ->get();

        // Tính tổng tiền
        $totalAmount = 0;
        foreach($checkoutItems as $item) {
            $totalAmount += $item->price * $item->quantity;
        }

        return view('checkout', compact('checkoutItems', 'totalAmount', 'selectedCartIds'));
    }
    // HÀM 1: XỬ LÝ LƯU ĐƠN HÀNG VÀO DATABASE
    public function placeOrder(Request $request)
    {
        $userId = Auth::id();
        $cartIds = $request->input('cart_ids'); // Danh sách ID giỏ hàng khách đang chọn mua
        $paymentMethod = $request->input('payment_method', 'COD'); // Lấy phương thức thanh toán, mặc định COD

        if (!$cartIds) {
            return redirect('/cart')->with('error', 'Không có sản phẩm nào để thanh toán!');
        }

        // 1. Lấy thông tin các món hàng trong giỏ để tính tiền
        $cartItems = CartItem::whereIn('id', $cartIds)->where('user_id', $userId)->get();
        $totalAmount = 0;
        
        foreach ($cartItems as $item) {
            $product = DB::table('products')->where('id', $item->product_id)->first();
            $totalAmount += ($product->price * $item->quantity);
        }

        // Cước phí vận chuyển giả định
        $shippingFee = 30000; 

        // 2. Tạo Đơn hàng mới (Lưu ý: Bạn hãy sửa tên cột cho khớp với DB cũ nếu cần)
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $userId,
            'total_amount' => $totalAmount + $shippingFee,
            'payment_method' => $paymentMethod,
            'status' => 'Chờ xác nhận', // Trạng thái đơn hàng
            // 'created_at' => now(), // Mở comment dòng này nếu bảng orders của bạn có cột thời gian
        ]);

        // 3. Chép từng món hàng từ Giỏ sang Chi tiết Đơn hàng
        foreach ($cartItems as $item) {
            $product = DB::table('products')->where('id', $item->product_id)->first();
            
            DB::table('order_details')->insert([
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'price' => $product->price,
                'quantity' => $item->quantity
            ]);
        }

        // 4. Mua xong rồi thì Xóa các món đó khỏi Giỏ Hàng
        CartItem::whereIn('id', $cartIds)->where('user_id', $userId)->delete();

        // 5. Chuyển hướng sang trang Hóa đơn
        return redirect('/receipt/' . $orderId);
    }

    // HÀM 2: HIỂN THỊ TRANG HÓA ĐƠN THÀNH CÔNG
    public function receipt($id)
{
    // 1. Tìm thông tin tổng quát của đơn hàng
    $order = DB::table('orders')->where('id', $id)->where('user_id', Auth::id())->first();
    
    if (!$order) {
        return redirect('/')->with('error', 'Không tìm thấy hóa đơn!');
    }

    // 2. Lấy CHI TIẾT các sản phẩm trong đơn hàng này (nối với bảng products để lấy tên và ảnh)
    $orderItems = DB::table('order_details')
        ->where('order_id', $id)
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->select('order_details.*', 'products.name', 'products.image_url')
        ->get();

    // 3. Gửi cả $order và $orderItems sang cho View
    return view('receipt', compact('order', 'orderItems'));
}
// HÀM 3: XEM LỊCH SỬ MUA HÀNG
    public function myOrders(Request $request)
    {
        $userId = Auth::id();
        
        // 1. Lấy trạng thái từ URL (ví dụ: ?status=da-giao). Nếu không có thì mặc định là 'all'
        $statusFilter = $request->query('status', 'all');

        // 2. Khởi tạo câu lệnh truy vấn
        $query = DB::table('orders')->where('user_id', $userId);

        // 3. Nếu khách chọn một trạng thái cụ thể (khác 'all') thì mới lọc
        if ($statusFilter !== 'all') {
            // Chuyển đổi slug từ URL sang chữ tiếng Việt khớp với DB
            $statusName = match($statusFilter) {
                'cho-xac-nhan' => 'Chờ xác nhận',
                'da-giao' => 'Đã giao',
                'da-huy' => 'Đã hủy',
                default => null
            };

            if ($statusName) {
                $query->where('status', $statusName);
            }
        }

        $orders = $query->orderBy('id', 'desc')->get();

        // 4. Lấy sản phẩm chi tiết cho từng đơn (giữ nguyên logic cũ)
        foreach ($orders as $order) {
            $order->items = DB::table('order_details')
                ->where('order_id', $order->id)
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('order_details.*', 'products.name', 'products.image_url')
                ->get();
        }

        // Gửi thêm biến $statusFilter sang View để biết tab nào đang active
        return view('my_orders', compact('orders', 'statusFilter'));
    }
}