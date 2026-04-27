<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Tạm tắt tính năng tự động lưu thời gian để tránh lỗi DB cũ
    public $timestamps = false; 

    // Khai báo các cột được phép lưu dữ liệu
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];
}