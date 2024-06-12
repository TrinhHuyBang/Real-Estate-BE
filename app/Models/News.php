<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'admin_id',
        'title',
        'image',
        'subtitle',
        'content',
        'source',
        'province',
        'status',
        'number_views',
    ];

    protected $attributes = [
        'number_views' => 0,
        'status' => 1,
    ];
}
