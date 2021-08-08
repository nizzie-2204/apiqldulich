<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanVienNhanHoTroToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhan_vien_nhan_ho_tro_tours', function (Blueprint $table) {
            $table->id();
            $table->integer('nv_id');
            $table->integer('gd_id');
            $table->integer('t_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhan_vien_nhan_ho_tro_tours');
    }
}
