<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Towing extends Model
{
    use HasFactory;

    // Allow mass assignment on these fields
    protected $fillable = [
        'user_id',
        'driver_id',
        'pickup_location',
        'destination',
        'vehicle_type',
        'description',
        'phone',
        'status',
        'price',
        'payment_status', // ✅ added
    ];

    // Relationship with Client (who created the request)
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Driver (who is assigned the request)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Relationship with Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'towing_id'); // ✅ explicitly define FK
    }
}
