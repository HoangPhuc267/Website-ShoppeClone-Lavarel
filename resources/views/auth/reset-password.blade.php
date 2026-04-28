<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu - F8 Shop</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ee4d2d; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 30px; border-radius: 4px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; font-size: 22px; color: #222; margin-bottom: 25px; }
        .input-control { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 2px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: #ee4d2d; color: #fff; border: none; font-weight: bold; cursor: pointer; border-radius: 2px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Nhập mật khẩu mới</h2>
        <form action="/reset-password" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <input type="password" name="password" class="input-control" placeholder="Mật khẩu mới..." required>
            <input type="password" name="password_confirmation" class="input-control" placeholder="Xác nhận mật khẩu mới..." required>
            <button type="submit" class="btn-submit">CẬP NHẬT MẬT KHẨU</button>
        </form>
    </div>
</body>
</html>