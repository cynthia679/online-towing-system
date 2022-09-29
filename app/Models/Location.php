<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "locations";
    protected $primaryKey = "id";
    protected $fillable = ['name','status','dateModified','dateCreated'];
    public $timestamps= false;
}
