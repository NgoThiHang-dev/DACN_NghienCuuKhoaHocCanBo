<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiangvien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giangvien', function (Blueprint $table) {
            $table->string('MaGV',8)->primary();
            $table->string('TenGV', 35);
            $table->string('email',35);
            $table->string('SDT',11);
            $table->string('ChucVu',35);
            $table->date('NgaySinh');
            $table->string('GioiTinh',10);
            $table->string('DiaChi',225);
            $table->string('Hinh',225);
            $table->string('MaKhoa',8)->unique();
            $table->foreign('MaKhoa')->references('MaKhoa')->on('khoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giangvien');
    }
}
