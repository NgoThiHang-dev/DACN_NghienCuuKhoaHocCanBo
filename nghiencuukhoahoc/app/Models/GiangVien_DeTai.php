<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiangVien_DeTai extends Model
{
   
    protected $table="gv_dt";
    protected $primaryKey = 'id_DeTai';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;
}
