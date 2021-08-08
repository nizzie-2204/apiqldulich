<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiaiDoanHoTrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giai_doan_ho_tros', function (Blueprint $table) {
            $table->id();
            $table->year('gd_tunam');
            $table->year('gd_dennam');
            $table->integer('dv_id');
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
        Schema::dropIfExists('giai_doan_ho_tros');
    }
}
