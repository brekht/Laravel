<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEssencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     *  ② Инициируем Поле `name`, как varchar max 50 символов, и как уникальное Поле
     *  ③ Инициируем Поле `user_id`, как INT, беззнаковое
     *  ④ Инициируем Поле `first_author`, как INT, беззнаковое
     *  ⑤ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`essences` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `name` VARCHAR(50) NOT NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    `first_author` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`),
     *    UNIQUE INDEX `name_UNIQUE` (`name` ASC))
     *  -- ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('essences', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();
            /* ② */ $table->string('name', 50)->unique();
            /* ③ */ $table->integer('user_id')->unsigned();
            /* ④ */ $table->integer('first_author')->unsigned();
            /* ⑤  */ $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('essences');
    }
}
