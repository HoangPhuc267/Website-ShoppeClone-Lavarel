<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - F8 Shop</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ee4d2d; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 30px; border-radius: 4px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; font-size: 22px; color: #222; margin-bottom: 25px; }
        .input-control { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 2px; box-sizing: border-box; font-size: 14px; }
        .btn-submit { width: 100%; padding: 12px; background: #ee4d2d; color: #fff; border: none; font-weight: bold; font-size: 14px; cursor: pointer; border-radius: 2px; }
        .btn-submit:hover { background: #d73211; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 2px; font-size: 14px; }
        .success { background: #e6f9e6; color: #26aa99; border: 1px solid #26aa99; }
        .error { background: #fff0f0; color: #ff4d4d; border: 1px solid #ff4d4d; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Đặt lại mật khẩu</h2>
        
        @if(session('message'))
            <div class="message success">{{ session('message') }}</div>
        @endif
        @if($errors->any())
            <div class="message error">{{ $errors->first() }}</div>
        @endif

        <form action="/forgot-password" method="POST">
            @csrf
            <p style="font-size: 14px; color: #555; margin-bottom: 15px;">Vui lòng nhập email tài khoản của bạn để nhận liên kết khôi phục mật khẩu.</p>
            <input type="email" name="email" class="input-control" placeholder="Email đăng nhập..." required>
            <button type="submit" class="btn-submit">GỬI LIÊN KẾT KHÔI PHỤC</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/login" style="color: #0055aa; text-decoration: none; font-size: 14px;">Quay lại đăng nhập</a>
        </div>
    </div>
</body>
</html>