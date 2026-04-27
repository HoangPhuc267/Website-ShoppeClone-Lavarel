<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem đã đăng nhập và có phải quyền admin không
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Cho phép đi tiếp vào trang Admin
        }

        // Nếu không phải admin, đá về trang chủ và báo lỗi
        return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực Quản trị!');
    }
}