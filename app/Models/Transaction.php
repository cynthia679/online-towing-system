<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = "mysql";
    protected $table = "transactions";
    protected $primaryKey = "id";

    protected $fillable = [
        'MSISDN',
        'accountNumber',
        'amount',
        'mpesaReceiptNumber',
        'balance',
        'transactionDate',
        'merchantRequestID',
        'checkoutRequestID',
        'resultCode',
        'resultDesc',
        'status',
        'firstName',
        'middleName',
        'lastName',
        'businessShortCode',
        'transactionType',
        'dateModified',
        'dateCreated',
        'towing_id', // ✅ make sure this is mass assignable
    ];

    public $timestamps = false;

    // ✅ Add relationship
    public function towing()
    {
        return $this->belongsTo(Towing::class, 'towing_id');
    }
}
