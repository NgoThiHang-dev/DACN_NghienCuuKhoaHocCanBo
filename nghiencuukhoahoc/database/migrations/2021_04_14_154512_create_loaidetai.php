<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoaidetai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaidetai', function (Blueprint $table) {
            $table->increments('id_LoaiDeTai');
            $table->string('TenDeTai',255);
            $table->string('DonViTinh',60);
            $table->string('TietQuyDoi',60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loaidetai');
    }
}
