<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tag extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
