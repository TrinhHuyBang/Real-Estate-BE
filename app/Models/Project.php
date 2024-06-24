<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'enterprise_id',
        'type_id',
        'name',
        'province',
        'district',
        'ward',
        'street',
        'address',
        'note',
        'project_status',
        'description',
        'apartment',
        'building',
        'start_price',
        'end_price',
        'size',
        'size_unit',
        'scale',
        'legal_documents',
        'builders',
        'designer',
        'status',
        'number_views'
    ];

    protected $attributes = [
        'status' => 0,
        'number_views' => 0,
    ];
}
