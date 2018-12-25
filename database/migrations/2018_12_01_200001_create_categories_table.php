<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     *  ② Инициируем Поле `title`, как varchar max 50 символов
     *  ③ Инициируем Поле `desc`, как varchar max 100 символов, и может быть NULL
     *  ④ Инициируем Поле `user_id`, как INT, беззнаковое
     *  ⑤ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`categories` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `title` VARCHAR(50) NOT NULL,
     *    `desc` VARCHAR(100) NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`))
     *  --ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();
            /* ② */ $table->string('title', 50);
            /* ③ */ $table->string('desc', 100)->nullable();
            /* ④ */ $table->integer('user_id')->unsigned();
            /* ⑤ */ $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
