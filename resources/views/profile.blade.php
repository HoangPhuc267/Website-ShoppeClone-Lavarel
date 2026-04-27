<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ Sơ Của Tôi - Shopee</title>
    <link href="https://unpkg.com/@csstools/normalize.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: Arial, sans-serif; }
        .cart-header { background: #fff; padding: 25px 0; border-bottom: 1px solid rgba(0,0,0,.09); margin-bottom: 20px;}
        .cart-header-inner { display: flex; justify-content: space-between; align-items: center; width: 1200px; margin: 0 auto; }
        .cart-brand { display: flex; align-items: flex-end; text-decoration: none; }
        .cart-logo { color: #ee4d2d; font-size: 3rem; font-weight: bold; margin-right: 15px; }
        .cart-title { font-size: 2rem; color: #ee4d2d; border-left: 1px solid #ee4d2d; padding-left: 15px; line-height: 1.2; }
        
        .container { width: 1200px; margin: 0 auto; display: flex; gap: 20px; padding-bottom: 50px;}
        
        /* Menu Trái (Giống y hệt trang Đơn Mua) */
        .sidebar { width: 180px; }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid #e8e8e8; }
        .user-avatar { width: 50px; height: 50px; border-radius: 50%; background: #ccc; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; }
        .user-name { font-size: 1.4rem; font-weight: bold; color: #333; }
        .menu-item { display: block; font-size: 1.4rem; color: #222; text-decoration: none; margin-bottom: 15px; transition: 0.2s;}
        .menu-item:hover, .menu-item.active { color: #ee4d2d; }
        .menu-item i { width: 20px; text-align: center; margin-right: 8px; color: #1a71ff; }
        .menu-item.active i { color: #ee4d2d; }

        /* Nội dung Phải: Form Hồ Sơ */
        .main-content { flex: 1; background: #fff; border-radius: 2px; box-shadow: 0 1px 1px 0 rgba(0,0,0,.05); padding: 0 30px 30px; }
        .profile-header { padding: 18px 0; border-bottom: 1px solid #efefef; margin-bottom: 30px; }
        .profile-title { font-size: 1.8rem; color: #333; margin: 0 0 5px; font-weight: 500; }
        .profile-desc { font-size: 1.4rem; color: #555; margin: 0; }
        
        .profile-body { display: flex; gap: 50px; }
        .profile-form { flex: 1; }
        .form-group { display: flex; align-items: center; margin-bottom: 30px; }
        .form-label { width: 20%; text-align: right; margin-right: 20px; font-size: 1.4rem; color: #555; }
        .form-input-wrap { flex: 1; }
        .form-input { width: 80%; height: 40px; padding: 0 15px; border: 1px solid #ccc; border-radius: 2px; outline: none; font-size: 1.4rem; transition: 0.2s;}
        .form-input:focus { border-color: #555; box-shadow: 0 0 3px rgba(0,0,0,0.1); }
        .form-input:disabled { background: #f5f5f5; cursor: not-allowed; border-color: #e8e8e8; color: #888;}
        
        .btn-save { background: #ee4d2d; color: #fff; border: none; padding: 10px 25px; border-radius: 2px; font-size: 1.4rem; cursor: pointer; transition: 0.2s; }
        .btn-save:hover { background: #f05d40; }

        /* Khối Avatar bên phải */
        .profile-avatar-sec { width: 250px; display: flex; flex-direction: column; align-items: center; border-left: 1px solid #efefef; padding-top: 20px; }
        .avatar-preview { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 1px solid #efefef; margin-bottom: 20px; padding-top:50px; padding-left: 20px;  }
        .btn-upload { background: #fff; border: 1px solid #ccc; padding: 10px 20px; border-radius: 2px; font-size: 1.4rem; cursor: pointer; color: #555; }
        .btn-upload:hover { background: #fdfdfd; }
    </style>
</head>
<body>

    <header class="cart-header">
        <div class="cart-header-inner">
            <a href="/" class="cart-brand">
                <i class="fas fa-shopping-bag cart-logo"></i>
                <span class="cart-title">Hồ Sơ Của Tôi</span>
            </a>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <div class="user-avatar"><i class="fas fa-user"></i></div>
                <div class="user-name">{{ $user->name ?? explode('@', $user->email)[0] }}</div>
            </div>
            <a href="/profile" class="menu-item active"><i class="far fa-user-circle" style="color: #ee4d2d;"></i> Tài khoản của tôi</a>
            <a href="/my-orders" class="menu-item"><i class="fas fa-clipboard-list"></i> Đơn Mua</a>
            <a href="/notifications" class="menu-item"><i class="far fa-bell"></i> Thông báo</a>
        </div>

        <div class="main-content">
            <div class="profile-header">
                <h1 class="profile-title">Hồ Sơ Của Tôi</h1>
                <p class="profile-desc">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>

            @if(session('success'))
                <div style="background: #e6f9e6; color: #26aa99; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="profile-body">
                <div class="profile-form">
                    <form action="/profile/update" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label">Email đăng nhập</label>
                            <div class="form-input-wrap">
                                <input type="email" class="form-input" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tên hiển thị</label>
                            <div class="form-input-wrap">
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}" placeholder="Ví dụ: Cù Hoàng Phúc" required>
                                @error('name')
                                    <span style="color: red; font-size: 1.2rem; display: block; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <div class="form-input-wrap">
                                <input type="text" name="phone" class="form-input" placeholder="Thêm số điện thoại...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Giới tính</label>
                            <div class="form-input-wrap" style="font-size: 1.4rem; color: #333; display: flex; gap: 20px;">
                                <label><input type="radio" name="gender" value="Nam" checked> Nam</label>
                                <label><input type="radio" name="gender" value="Nữ"> Nữ</label>
                                <label><input type="radio" name="gender" value="Khác"> Khác</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"></label>
                            <div class="form-input-wrap">
                                <button type="submit" class="btn-save">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="profile-avatar-sec">
                    <img src="https://down-vn.img.susercontent.com/file/vn-11134233-7r98o-lsttivj3yub3bd_tn" alt="Avatar" class="avatar-preview">
                    <button type="button" class="btn-upload">Chọn Ảnh</button>
                    <div style="font-size: 1.2rem; color: #999; margin-top: 15px; text-align: center; line-height: 1.5;">
                        Dụng lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>