<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AccountController extends Controller
{
    // 1. Hàm hiển thị trang Hồ sơ
    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người đang đăng nhập
        return view('profile', compact('user'));
    }

    // 2. Hàm xử lý khi bấm nút "Lưu"
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Kiểm tra dữ liệu an toàn
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Vui lòng nhập tên của bạn!'
        ]);

        // Cập nhật tên mới vào Database
        $user->name = $request->name;
        
        // Lưu ý: Nếu DB cũ của bạn có cột phone, address thì mở comment 2 dòng dưới ra nhé
        // $user->phone = $request->phone; 
        // $user->address = $request->address;

        $user->save();

        return back()->with('success', 'Cập nhật Hồ sơ thành công!');
    }
    // Hàm hiển thị trang Thông báo
    public function notifications()
    {
        $userId = Auth::id();
        
        $notifications = DB::table('notifications')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('notifications', compact('notifications'));
    }
}