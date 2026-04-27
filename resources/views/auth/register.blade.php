.<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Shopee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Tận dụng lại CSS từ trang Login bạn đã có */
        body { margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #fff; }
        .login-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; width: 1200px; margin: 0 auto; }
        .login-logo { color: #ee4d2d; font-size: 35px; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 10px;}
        .login-main { background-color: #ee4d2d; padding: 50px 0; min-height: 500px; display: flex; align-items: center;}
        .login-container { width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .login-form-box { background: #fff; width: 400px; padding: 30px; border-radius: 4px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); box-sizing: border-box;}
        .login-input { width: 100%; height: 40px; margin-bottom: 15px; padding: 0 10px; border: 1px solid #dbdbdb; border-radius: 2px; box-sizing: border-box; outline: none;}
        .btn-login { width: 100%; height: 40px; background: #ee4d2d; color: #fff; border: none; cursor: pointer; text-transform: uppercase; margin-top: 10px;}
    </style>
</head>
<body>
    <div class="login-header">
        <div style="display: flex; align-items: flex-end; gap: 15px;">
            <a href="/" class="login-logo"><i class="fas fa-shopping-bag"></i> Shopee</a>
            <span style="font-size: 24px; color: #222;">Đăng ký</span>
        </div>
    </div>

    <div class="login-main">
        <div class="login-container">
            <div style="color: #fff; text-align: center; flex: 1;">
                <i class="fas fa-shopping-bag" style="font-size: 100px;"></i>
                <h1>Shopee</h1>
                <p style="font-size: 24px;">Nền tảng thương mại điện tử<br>yêu thích ở Đông Nam Á & Đài Loan</p>
            </div>
            
            <div class="login-form-box">
                <div style="font-size: 20px; margin-bottom: 30px;">Đăng ký</div>
                <form action="/register" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div style="color: red; margin-bottom: 15px; font-size: 13px; text-align: center;">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                        </div>
                    @endif
                    <input type="email" name="email" class="login-input" placeholder="Email" required>
                    <input type="password" name="password" class="login-input" placeholder="Mật khẩu" required>
                    <input type="password" name="re_password" class="login-input" placeholder="Nhập lại mật khẩu" required>
                    <button type="submit" class="btn-login">ĐĂNG KÝ</button>
                </form>
                
                <div style="text-align: center; margin-top: 30px; font-size: 14px; color: #ccc;">
                    Bạn đã có tài khoản? <a href="/login" style="color: #ee4d2d; text-decoration: none; font-weight: bold;">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>

    @include('auth.footer')
</body>
</html>