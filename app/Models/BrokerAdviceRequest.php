<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerAdviceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'broker_id',
        'status'
    ];

    protected $attributes = [
        'status' => 0,
    ];

    public $timestamps = false;
}
