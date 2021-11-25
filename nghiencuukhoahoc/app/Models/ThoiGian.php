<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThoiGian extends Model
{
    use HasFactory;
    protected $table="thoigian";
    public $timestamps = false;
    
    protected $primaryKey = 'id_ThoiGian';
    public $incrementing = false;
}
