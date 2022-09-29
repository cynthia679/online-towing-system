<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "customer_requests";
    protected $primaryKey = "id";
    protected $fillable = ['userId','productId','fromAddress','fromLongitude','fromLatitude','toAddress','toLongitude','toLatitude','requestedAt','distance','charge','status','dateModified','dateCreated'];
    public $timestamps= false;
}
