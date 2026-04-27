<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Công cụ băm mật khẩu
use App\Models\User; // Gọi Model User để làm việc với DB

class AuthController extends Controller

{
    // Hàm hiển thị trang Đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Hàm hiển thị trang Đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }
    // HÀM XỬ LÝ ĐĂNG KÝ
    public function register(Request $request)
    {
        // 1. Nhờ bảo vệ Laravel kiểm tra dữ liệu cực nhanh
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'], // Tự động check trùng email trong DB!
            'password' => ['required', 'min:6'],
            're_password' => ['required', 'same:password'] // Tự động so sánh 2 ô mật khẩu có khớp không!
        ], [
            // Tùy chỉnh câu thông báo lỗi bằng tiếng Việt
            'email.unique' => 'Email này đã được đăng ký, vui lòng dùng email khác!',
            're_password.same' => 'Mật khẩu nhập lại không khớp!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!'
        ]);

        // 2. Tạo User mới (Tự động mã hóa mật khẩu)
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Bạn có thể set mặc định role cho khách mới
        ]);

        // 3. Đăng nhập tự động cho khách luôn và cho về Trang chủ
        Auth::login($user);
        
        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }
    
    // HÀM XỬ LÝ ĐĂNG NHẬP
    public function login(Request $request)
    {
        // 1. Kiểm tra dữ liệu gửi lên
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Nhờ Auth kiểm tra trong CSDL (Tự động mã hóa và so sánh mật khẩu)
        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công -> Reset lại Session để bảo mật
            $request->session()->regenerate();
            
            // 3. Phân quyền: Kiểm tra cột 'role' y như code PHP cũ của bạn
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard'); // Lát nữa mình sẽ tạo Route này sau
            }
            
            // Nếu là Khách hàng bình thường thì cho về Trang chủ
            return redirect('/');
        }

        // 4. Nếu sai tài khoản hoặc mật khẩu -> Báo lỗi đỏ
        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác!',
        ])->onlyInput('email');
    }

    // HÀM XỬ LÝ ĐĂNG XUẤT
    public function logout(Request $request)
    {
        Auth::logout(); // Hủy Auth
        $request->session()->invalidate(); // Xóa sạch Session
        $request->session()->regenerateToken(); // Đổi thẻ bảo mật mới
        
        return redirect('/');
    }
}