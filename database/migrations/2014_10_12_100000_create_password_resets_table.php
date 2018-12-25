<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Для Поля `email` укажем, что Поле не должно быть более 128
     *  ② Для Поля `token` укажем, что Поле не должно быть более 128
     * --------------------------------------------------------------------------
     *
     *
     *
     *
     */

    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            /* ① */ $table->string('email', 128)->index();
            /* ② */ $table->string('token', 128);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
