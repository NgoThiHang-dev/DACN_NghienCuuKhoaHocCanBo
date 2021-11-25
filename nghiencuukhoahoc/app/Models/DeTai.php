<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeTai extends Model
{
    protected $table="detai";
    protected $primaryKey = 'id_DeTai';
    public $incrementing = false;
    protected $primaryKey1 = 'MaGV';
    public $incrementing1 = false;
    public $timestamps = false;
    use HasFactory;
}
