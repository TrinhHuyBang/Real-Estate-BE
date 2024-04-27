<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'abbreviation',
        'description',
        'logo',
        'phone_number',
        'email',
        'address',
        'website',
        'business_number',
        'certificate_url',
        'main_field',
        'status',
    ];

    protected $attributes = [
        'status' => 0,
    ];
}
