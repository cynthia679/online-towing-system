<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TowingPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'min_distance',
        'max_distance',
        'price',
        'active',
    ];

    protected $casts = [
        'min_distance' => 'decimal:2',
        'max_distance' => 'decimal:2',
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];
}
