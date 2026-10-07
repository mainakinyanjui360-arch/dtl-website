<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'tagline',
        'description',
        'icon',
        'highlights',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'highlights' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];
}
