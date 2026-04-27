<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Shopee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #fff; }
        
        /* Header tối giản */
        .login-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; width: 1200px; margin: 0 auto; }
        .login-header-left { display: flex; align-items: flex-end; gap: 15px; }
        .login-logo { color: #ee4d2d; font-size: 35px; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 10px;}
        .login-title { font-size: 24px; color: #222; margin-bottom: 4px; }
        .login-help { color: #ee4d2d; text-decoration: none; font-size: 14px; }
        
        /* Phần thân cam */
        .login-main { background-color: #ee4d2d; padding: 50px 0; height: 500px; display: flex; align-items: center;}
        .login-container { width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        
        /* Banner chữ bên trái */
        .login-banner { color: #fff; text-align: center; }
        .login-banner i { font-size: 100px; }
        .login-banner h1 { font-size: 40px; margin: 20px 0 10px; }
        .login-banner p { font-size: 24px; font-weight: 300; margin: 0; }
        
        /* Form đăng nhập bên phải */
        .login-form-box { background: #fff; width: 400px; padding: 30px; border-radius: 4px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); box-sizing: border-box;}
        .login-form-header { font-size: 20px; color: #222; margin-bottom: 30px; }
        .login-input { width: 100%; height: 40px; margin-bottom: 15px; padding: 0 10px; border: 1px solid #dbdbdb; border-radius: 2px; box-sizing: border-box; font-size: 14px; outline: none;}
        .login-input:focus { border-color: #888; }
        .btn-login { width: 100%; height: 40px; background: #ee4d2d; color: #fff; border: none; font-size: 14px; cursor: pointer; border-radius: 2px; text-transform: uppercase; margin-bottom: 10px;}
        .btn-login:hover { background: #f05d40; }
        
        /* Chữ nhỏ & Mạng xã hội */
        .login-links { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 20px;}
        .login-links a { color: #0055aa; text-decoration: none; }
        .login-divider { display: flex; align-items: center; margin-bottom: 20px; }
        .login-divider::before, .login-divider::after { content: ""; flex: 1; border-bottom: 1px solid #dbdbdb; }
        .login-divider span { padding: 0 15px; color: #ccc; font-size: 12px; text-transform: uppercase; }
        
        .login-socials { display: flex; gap: 10px; margin-bottom: 30px;}
        .btn-social { flex: 1; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid #dbdbdb; background: #fff; cursor: pointer; text-decoration: none; color: #333; font-size: 14px;}
        .btn-social i { margin-right: 8px; font-size: 18px; }
        .btn-fb { color: #1877f2; }
        .btn-gg { color: #db4437; }
        
        .login-footer { text-align: center; font-size: 14px; color: #ccc;}
        .login-footer a { color: #ee4d2d; text-decoration: none; font-weight: bold;}
    </style>
</head>
<body>
    <div class="login-header">
        <div class="login-header-left">
            <a href="/" class="login-logo"><i class="fas fa-shopping-bag"></i> Shopee</a>
            <span class="login-title">Đăng nhập</span>
        </div>
        <a href="#" class="login-help">Bạn cần giúp đỡ?</a>
    </div>

    <div class="login-main">
        <div class="login-container">
            <div class="login-banner">
                <i class="fas fa-shopping-bag"></i>
                <h1>Shopee</h1>
                <p>Nền tảng thương mại điện tử<br>yêu thích ở Đông Nam Á & Đài Loan</p>
            </div>
            
            <div class="login-form-box">
                <div class="login-form-header">Đăng nhập</div>
                
                <form action="/login" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div style="color: red; margin-bottom: 15px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <input type="text" name="email" class="login-input" placeholder="Email/Số điện thoại/Tên đăng nhập" required>
                    <input type="password" name="password" class="login-input" placeholder="Mật khẩu" required>
                    <button type="submit" class="btn-login">ĐĂNG NHẬP</button>
                </form>
                
                <div class="login-links">
                    <a href="#">Quên mật khẩu</a>
                    <a href="#">Đăng nhập với SMS</a>
                </div>
                
                <div class="login-divider"><span>HOẶC</span></div>
                
                <div class="login-socials">
                    <a href="#" class="btn-social"><i class="fab fa-facebook btn-fb"></i> Facebook</a>
                    <a href="#" class="btn-social"><i class="fab fa-google btn-gg"></i> Google</a>
                </div>
                
                <div class="login-footer">
                    Bạn mới biết đến Shopee? <a href="/register">Đăng ký</a>
                </div>
            </div>
        </div>
    </div>
    @include('auth.footer')
</body>
</html>