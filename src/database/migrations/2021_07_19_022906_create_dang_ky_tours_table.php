<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDangKyToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dang_ky_tours', function (Blueprint $table) {
            $table->id();
            $table->string('dkt_hoten');
            $table->string('dkt_sdt');
            $table->year('dkt_namsinh');
            $table->char('dkt_gioitinh', 1);
            $table->string('dkt_diachi')->nullable();
            $table->integer('nv_id');
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
        Schema::dropIfExists('dang_ky_tours');
    }
}
