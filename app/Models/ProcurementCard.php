<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementCard extends Model
{
    protected $fillable = [
        'title',
        'tagline',
        'description',
        'image',
        'brands',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'brands' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];
}
