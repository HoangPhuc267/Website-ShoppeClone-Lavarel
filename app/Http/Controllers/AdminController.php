<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    // 1. Giao diện Tổng quan Admin
    public function dashboard()
    {
        // 1. Lấy thống kê nhanh để show ra màn hình
        $totalUsers = DB::table('users')->where('role', 'user')->count();
        $totalOrders = DB::table('orders')->count();
        $totalRevenue = DB::table('orders')->where('status', 'Đã giao')->sum('total_amount');

        // 2. Tính toán dữ liệu Biểu đồ (7 ngày gần nhất)
        $days = [];
        $revenue_data = [];

        for ($i = 6; $i >= 0; $i--) {
            // Lấy ngày hiện tại lùi dần về 6 ngày trước
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('d/m'); // Tạo mảng nhãn: VD ['17/04', '18/04', ...]

            // Tính tổng doanh thu của các đơn "Đã giao" trong ngày đó
            $dailyTotal = DB::table('orders')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->where('status', 'Đã giao')
                ->sum('total_amount');

            $revenue_data[] = $dailyTotal; // Thêm vào mảng dữ liệu
        }

        // 3. Gửi tất cả sang View
        return view('admin.dashboard', compact('totalUsers', 'totalOrders', 'totalRevenue', 'days', 'revenue_data'));
    }

    // 2. Tính năng Gửi thông báo hàng loạt
    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ]);

        // Lấy ID của toàn bộ khách hàng (role = user)
        $userIds = DB::table('users')->where('role', 'user')->pluck('id');
        
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title' => $request->title,
                'message' => $request->message,
                // 'created_at' => now() // Mở comment nếu DB của bạn cần thời gian chuẩn
            ];
        }

        // Bắn 1 phát lưu toàn bộ thông báo vào DB
        if (!empty($notifications)) {
            DB::table('notifications')->insert($notifications);
        }

        return back()->with('success', 'Đã gửi thông báo đến ' . count($userIds) . ' khách hàng thành công!');
    }

    // 5. Hiển thị danh sách Danh mục
        public function categoryIndex()
        {
            $categories = DB::table('categories')
                ->select('categories.*')
                // Đếm số sản phẩm thuộc danh mục này
                ->selectSub(function ($query) {
                    $query->from('products')
                        ->whereColumn('products.category_id', 'categories.id')
                        ->selectRaw('count(*)');
                }, 'product_count')
                ->orderBy('id', 'desc')
                ->get();

            return view('admin.categories', compact('categories'));
        }

        // 6. Thêm danh mục mới
        public function categoryStore(Request $request)
        {
            $request->validate(['name' => 'required']);
            
            DB::table('categories')->insert([
                'name' => $request->name,
                // 'created_at' => now() // Mở comment nếu bảng có cột này
            ]);

            return redirect('/admin/categories')->with('success', 'Thêm danh mục mới thành công!');
        }

        // 7. Lấy dữ liệu để Sửa
        public function categoryEdit($id)
        {
            $category = DB::table('categories')->where('id', $id)->first();
            $categories = $this->categoryIndex()->categories; // Lấy lại danh sách để hiện bên dưới form sửa
            
            return view('admin.categories', [
                'categories' => $categories,
                'categoryEdit' => $category
            ]);
        }

        // 8. Cập nhật danh mục
        public function categoryUpdate(Request $request, $id)
        {
            DB::table('categories')->where('id', $id)->update([
                'name' => $request->name
            ]);

            return redirect('/admin/categories')->with('success', 'Cập nhật danh mục thành công!');
        }

        // 9. Xóa danh mục
        public function categoryDelete($id)
        {
            // Kiểm tra xem danh mục có sản phẩm không trước khi xóa (giống lưu ý của bạn)
            $hasProduct = DB::table('products')->where('category_id', $id)->exists();
            
            if ($hasProduct) {
                return back()->with('error', 'Không thể xóa! Danh mục này đang có sản phẩm.');
            }

            DB::table('categories')->where('id', $id)->delete();
            return back()->with('success', 'Đã xóa danh mục thành công!');
        }
        // 10. Hiển thị danh sách sản phẩm
        public function productIndex()
        {
            // Lấy danh sách sản phẩm kèm tên danh mục (JOIN)
            $products = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as cat_name')
                ->orderBy('products.id', 'desc')
                ->get();

            // Lấy danh sách danh mục để hiện ở thẻ <select> trong form thêm
            $categories = DB::table('categories')->get();

            return view('admin.products', compact('products', 'categories'));
        }

        // 11. Xử lý thêm sản phẩm mới (có Upload ảnh)
        public function productStore(Request $request)
        {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $imageName = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Tạo tên file duy nhất
                $imageName = time() . '_' . $file->getClientOriginalName();
                // Lưu vào thư mục assets/img trong public
                $file->move(public_path('assets/img'), $imageName);
            }

            DB::table('products')->insert([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image_url' => 'assets/img/' . $imageName, // Lưu đường dẫn ảnh vào DB
                // 'created_at' => now()
            ]);

            return back()->with('success', 'Thêm sản phẩm "' . $request->name . '" thành công!');
        }

        // 12. Xóa sản phẩm
        public function productDelete($id)
        {
            DB::table('products')->where('id', $id)->delete();
            return back()->with('success', 'Đã xóa sản phẩm thành công!');
        }

        // 13. Lấy dữ liệu để Sửa sản phẩm
        public function productEdit($id)
        {
            $product = DB::table('products')->where('id', $id)->first();
            $categories = DB::table('categories')->get();

            return view('admin.edit_product', compact('product', 'categories'));
        }

        // 14. Cập nhật sản phẩm
        public function productUpdate(Request $request, $id)
        {
            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $imageName = $request->old_image; // Giữ nguyên tên ảnh cũ nếu không có ảnh mới

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/img'), $imageName);
            }

            DB::table('products')->where('id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image_url' => 'assets/img/' . $imageName
            ]);

            return redirect('/admin/products')->with('success', 'Cập nhật sản phẩm thành công!');
        }
        // 17. Hiển thị danh sách khách hàng
            public function userIndex()
            {
                // Lấy toàn bộ user, ưu tiên hiện Admin lên đầu rồi mới đến User mới nhất
                $users = DB::table('users')
                    ->orderBy('role', 'asc')
                    ->orderBy('id', 'desc')
                    ->get();

                return view('admin.users', compact('users'));
            }

            // 18. Xử lý xóa tài khoản
            public function userDelete($id)
            {
                // Bảo mật: Không cho phép Admin tự xóa chính mình
                if ($id == Auth::id()) {
                    return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
                }

                DB::table('users')->where('id', $id)->delete();
                return back()->with('success', 'Đã xóa tài khoản người dùng thành công!');
            }

            public function orderIndex() 
            {
                $orders = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.*', 'users.email as customer_email')
                    ->orderBy('orders.id', 'desc')
                    ->get();

                return view('admin.orders', compact('orders'));
            }

            public function orderUpdateStatus(Request $request, $id) 
            {
                DB::table('orders')->where('id', $id)->update([
                    'status' => $request->new_status
                ]);

                return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #ORD-' . $id);
            }

            public function orderDetail($id) 
            {
                $order = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->where('orders.id', $id)
                    ->select('orders.*', 'users.email')
                    ->first();

                $details = DB::table('order_details')
                    ->join('products', 'order_details.product_id', '=', 'products.id')
                    ->where('order_details.order_id', $id)
                    ->select('order_details.*', 'products.name', 'products.image_url')
                    ->get();

                return view('admin.order_detail', compact('order', 'details'));
            }

}