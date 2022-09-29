<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "settings";
    protected $primaryKey = "id";
    protected $fillable = [];
    public $timestamps= false;
}
