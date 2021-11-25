<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiDeTai extends Model
{
    use HasFactory;
    protected $table="loaidetai";
    protected $primaryKey = 'id_LoaiDeTai';
    public $timestamps = false;
}
