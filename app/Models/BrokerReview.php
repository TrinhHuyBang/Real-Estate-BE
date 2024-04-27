<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'broker_id',
        'broker_request_id',
        'rating',
        'review'
    ];
}
