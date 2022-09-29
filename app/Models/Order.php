<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = ['userId','customerRequestId','clientId','fromAddress','toAddress','charge','distance','status','dateModified','dateCreated'];
    public $timestamps= false;
}
