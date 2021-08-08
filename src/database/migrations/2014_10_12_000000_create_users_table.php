<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nv_ten');
            $table->year('nv_namsinh');
            $table->string('nv_diachi')->nullable();
            $table->string('nv_sdt')->nullable();
            $table->char('nv_gioitinh', 1);
            $table->date('nv_thoigianvaolam');
            $table->string('username');
            $table->string('password');
            $table->softDeletes();
            $table->bigInteger('ltk_id')->default(3);
            $table->bigInteger('dv_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
