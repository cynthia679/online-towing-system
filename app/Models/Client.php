<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "clients";
    protected $primaryKey = "id";
    protected $fillable = ['MSISDN','firstName','lastName','email','password','status','activationCode','loggedIn','loggedInAt','dateModified','dateCreated'];
    public $timestamps= false;
}
