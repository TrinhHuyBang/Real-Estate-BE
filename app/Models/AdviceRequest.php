<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdviceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'title',
        'description',
        'province',
        'district',
        'project_id',
        'data',
        'status',
    ];

    protected $attributes = [
        'status' => 1,
    ];

    protected $casts = [
        'data' => 'json',
    ];
}
