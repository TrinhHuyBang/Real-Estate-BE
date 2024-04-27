<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubField extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'enterprise_id'
    ];

    public $timestamps = false;
}
