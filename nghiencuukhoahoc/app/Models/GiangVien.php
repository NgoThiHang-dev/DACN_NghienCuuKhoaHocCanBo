<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $table="giangvien";
    protected $table1="taikhoan";
    protected $primaryKey = 'MaGV';
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;
}
