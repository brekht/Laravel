<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
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
     *  ③ Инициируем Поле `short_text`, как varchar max 200 символов
     *  ④ Инициируем Поле `full_text`, как тип Поля MEDIUMTEXT
     *  ⑤ Инициируем Поле `user_id`, как INT, беззнаковое
     *  ⑥ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`articles` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `title` VARCHAR(50) NOT NULL,
     *    `short_text` VARCHAR(200) NOT NULL,
     *    `full_text` MEDIUMTEXT NOT NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`))
     *  --ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();
            /* ② */ $table->string('title', 50);
            /* ③ */ $table->string('short_text', 200);
            /* ④ */ $table->mediumText('full_text');
            /* ⑤ */ $table->integer('user_id')->unsigned();
            /* ⑥ */ $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
