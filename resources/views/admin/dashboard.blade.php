@extends('admin.layouts.admin')

@section('title', 'Tổng quan')

@section('styles')
<style>
    /* 3 Khối Thống Kê (Style mới) */
    .dashboard-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 30px; }
    .stat-card-new { display: flex; justify-content: space-between; align-items: center; padding: 25px; border-radius: 8px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .stat-info-new h4 { margin: 0; font-size: 1.3rem; color: #888; text-transform: uppercase; margin-bottom: 8px; }
    .stat-info-new div { font-size: 2.4rem; font-weight: bold; color: #333; margin-bottom: 5px; }
    .stat-info-new span { font-size: 1.2rem; color: #aaa; }
    .stat-icon-new { width: 55px; height: 55px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2.4rem; }
    
    .icon-blue { background: linear-gradient(135deg, #4099ff, #73b4ff); }
    .icon-green { background: linear-gradient(135deg, #2ed8b6, #59e0c5); }
    .icon-orange { background: linear-gradient(135deg, #ffb64d, #ffcb80); }

    /* Form gửi thông báo */
    .form-group { margin-bottom: 15px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 500; color: #444; font-size: 1.4rem;}
    .form-control { width: 100%; padding: 12px; border: 1px solid #e1e1e1; border-radius: 4px; font-size: 1.4rem; box-sizing: border-box; outline: none; transition: 0.2s;}
    .form-control:focus { border-color: var(--primary-color); }
    .btn-submit { background: var(--primary-color); color: #fff; border: none; padding: 12px 25px; font-size: 1.4rem; border-radius: 4px; cursor: pointer; transition: 0.2s; font-weight: bold;}
    .btn-submit:hover { background: #d73211; }
    
    .alert-success { background: #f6ffed; color: #52c41a; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #b7eb8f; font-size: 1.4rem;}
</style>
@endsection

@section('content')
    
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-grid">
        <div class="stat-card-new">
            <div class="stat-info-new">
                <h4>Khách Hàng</h4>
                <div>{{ $totalUsers }}</div>
                <span>Số lượng tài khoản</span>
            </div>
            <div class="stat-icon-new icon-blue"><i class="fas fa-users"></i></div>
        </div>

        <div class="stat-card-new">
            <div class="stat-info-new">
                <h4>Đơn Hàng</h4>
                <div>{{ $totalOrders }}</div>
                <span>Tổng đơn hệ thống</span>
            </div>
            <div class="stat-icon-new icon-orange"><i class="fas fa-shopping-bag"></i></div>
        </div>

        <div class="stat-card-new">
            <div class="stat-info-new">
                <h4>Doanh Thu</h4>
                <div style="color: #ee4d2d;">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                <span>Đơn hàng đã giao</span>
            </div>
            <div class="stat-icon-new icon-green"><i class="fas fa-wallet"></i></div>
        </div>
    </div>

    <div class="admin-card" style="margin-bottom: 30px;">
        <h2 class="admin-title"><i class="fas fa-chart-area" style="color: #4099ff; margin-right: 8px;"></i> Doanh Thu 7 Ngày Qua</h2>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    <div class="admin-card" style="max-width: 800px;">
        <h2 class="admin-title"><i class="fas fa-bullhorn" style="color: #ee4d2d; margin-right: 8px;"></i> Gửi Thông Báo Hàng Loạt</h2>
        
        <form action="/admin/send-notification" method="POST" style="margin-top: 20px;">
            @csrf
            <div class="form-group">
                <label class="form-label">Tiêu đề thông báo</label>
                <input type="text" name="title" class="form-control" placeholder="VD: 🎁 Tặng bạn Voucher FREESHIP" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nội dung chi tiết</label>
                <textarea name="message" class="form-control" rows="4" placeholder="Nhập nội dung mã giảm giá hoặc chương trình khuyến mãi vào đây..." required></textarea>
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Phát hành thông báo</button>
        </form>
    </div>
@endsection

        @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    // Laravel json_encode sẽ tự động chuyển mảng PHP thành mảng JS
                    labels: {!! json_encode($days) !!},
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: {!! json_encode($revenue_data) !!},
                        backgroundColor: 'rgba(64, 153, 255, 0.2)',
                        borderColor: '#4099ff',
                        borderWidth: 3,
                        tension: 0.4, // Làm cong mượt đường dây
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4099ff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        </script>
        @endsection