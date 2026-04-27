@extends('admin.layouts.admin')

@section('title', 'Quản lý Khách hàng')

@section('styles')
<style>
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: #f8f8f8; color: #666; text-align: left; padding: 15px; border-bottom: 2px solid #eee; font-size: 1.4rem; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 1.4rem; color: #444; }
    .admin-table tr:hover { background: #fafafa; }

    /* Badge phân quyền */
    .badge { padding: 4px 8px; border-radius: 12px; font-size: 1.2rem; font-weight: bold; }
    .badge-admin { background: #fff1f0; color: #ff4d4f; border: 1px solid #ffa39e; }
    .badge-user { background: #e6f7ff; color: #1890ff; border: 1px solid #91d5ff; }

    .btn-del { color: #ff4d4d; text-decoration: none; border: 1px solid #ff4d4d; padding: 5px 10px; border-radius: 3px; transition: 0.3s; }
    .btn-del:hover { background: #ff4d4d; color: #fff; }
</style>
@endsection

@section('content')
<div class="admin-card">
    <h2 class="admin-title">DANH SÁCH TÀI KHOẢN HỆ THỐNG</h2>

    @if(session('success'))
        <div style="background: #e6f9e6; color: #26aa99; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background: #fff0f0; color: #ff4d4d; padding: 15px; border-radius: 2px; margin-bottom: 20px; font-size: 1.4rem;">
            {{ session('error') }}
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th width="80">ID</th>
                <th>Email / Tài khoản</th>
                <th>Quyền hạn</th>
                <th>Ngày tham gia</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td style="font-weight: bold;">{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span class="badge badge-admin"><i class="fas fa-star"></i> Admin</span>
                    @else
                        <span class="badge badge-user"><i class="fas fa-user"></i> Khách hàng</span>
                    @endif
                </td>
                <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                <td>
                    <a href="/admin/users/delete/{{ $user->id }}" 
                       class="btn-del" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection