<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('t_ten');
            $table->text('t_mota')->nullable();
            $table->integer('t_soluong');
            $table->date('t_tgbatdaudk');
            $table->date('t_tgketthucdk');
            $table->date('t_ngaybatdau');
            $table->date('t_ngayketthuc');
            $table->double('t_gia');
            $table->softDeletes();
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
        Schema::dropIfExists('tours');
    }
}
