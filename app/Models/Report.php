<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'name',
        'post_id',
        'email',
        'phone',
        'status',
    ];

    protected $attributes = [
        'status' => 0,
    ];
}
