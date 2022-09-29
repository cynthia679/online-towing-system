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
    protected $fillable = ['MSISDN','accountNumber','amount','mpesaReceiptNumber','balance','transactionDate','merchantRequestID','checkoutRequestID','resultCode','resultDesc','status','firstName','middleName','lastName','businessShortCode','transactionType','dateModified','dateCreated'];
    public $timestamps= false;
}
