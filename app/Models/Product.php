<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = ['name','make','model','yom','registrationNumber','color','description','status','dateModified','dateCreated'];
    public $timestamps= false;
}
