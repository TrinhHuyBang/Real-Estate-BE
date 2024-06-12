<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'broker_id',
        'type_id',
        'project_id',
        'province',
        'district'
    ];

    public $timestamps = false;
}
