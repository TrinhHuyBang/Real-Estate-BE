<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'title', // Tiêu đề
        'description', // Miêu tả
        'province',
        'district', // Quận huyện
        'ward', // Phường xã
        'street',  // Địa chỉ cụ thể 
        'address',
        'legal_documents',  //Giấy tờ
        'furniture', // Nội thất
        'bedroom', // Số phòng ngủ
        'toilet', // Số phòng tắm/vệ sinh
        'floor',  // Số tầng
        'size',   // Diện tích
        'price', // Giá cả
        'unit',
        'type_id',
        'status',  // Trạng thái bài đăng, (đã duyệt, chờ duyệt)
        'published_at',
        'created_at',
        'updated_at',
        'expired_at',
    ];

    protected $attributes = [
        'status' => 0,
        'published_at' => null,
        'legal_documents' => null,
        'furniture' => null,
        'bedroom' => null,
        'toilet'=> null,
        'floor' => null,
        'street' => null,
        'project_id' => null,
        'expired_at' => null,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }
}
