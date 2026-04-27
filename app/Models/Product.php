<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 1. Chỉ định chính xác tên bảng sản phẩm của bạn trong MySQL
    protected $table = 'products'; 

    // 2. Chỉ định tên cột khóa chính (nếu khóa chính của bạn không phải tên là 'id')
    protected $primaryKey = 'id'; 

    // 3. Tắt tính năng tự động cập nhật thời gian (nếu bảng của bạn không có 2 cột created_at và updated_at)
    public $timestamps = false; 
}