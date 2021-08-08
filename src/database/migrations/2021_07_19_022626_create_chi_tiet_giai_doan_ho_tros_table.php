<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietGiaiDoanHoTrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_giai_doan_ho_tros', function (Blueprint $table) {
            $table->id();
            $table->integer('ctgdhotro_tuthamnien');
            $table->integer('ctgdhotro_denthamnien');
            $table->double('ctgdhotro_sotienhotro');
            $table->string('ctgdhotro_diengiai')->nullable();
            $table->integer('gd_id');
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
        Schema::dropIfExists('chi_tiet_giai_doan_ho_tros');
    }
}
