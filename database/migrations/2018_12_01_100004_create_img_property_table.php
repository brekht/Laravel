<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImgPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     *  ② Инициируем Поле `img`, как varchar 50 символов, Уникальное, и не NULL
     *  ③ Инициируем Поле `essences_id`, как Поле INT (беззнаковое), Уникальное, как Внешний Ключ к Полю `id` Таблицы `essences`
     *  ④ Инициируем Поле `user_id`, как INT, беззнаковое
     *  ⑤ Инициируем Поле `first_author`, как INT, беззнаковое
     *  ⑥ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`img_property` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `img` VARCHAR(50) NOT NULL,
     *    `essences_id` INT UNSIGNED NOT NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    `first_author` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`),
     *    INDEX `fk_img_property_essences_idx` (`essences_id` ASC),
     *    UNIQUE INDEX `essences_id_UNIQUE` (`essences_id` ASC),
     *    UNIQUE INDEX `img_UNIQUE` (`img` ASC),
     *    CONSTRAINT `fk_img_property_essences`
     *      FOREIGN KEY (`essences_id`)
     *      REFERENCES `nature`.`essences` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION)
     *  ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('img_property', function (Blueprint $table) {

            /* ① */ $table->increments('id')->unsigned();

            /* ② */ $table->string('img', 50)->unique();

            /* ③ */ $table->integer('essences_id')->unsigned()->unique();
                     $table->foreign('essences_id')->references('id')->on('essences')->onDelete('cascade');

            /* ④ */ $table->integer('user_id')->unsigned();

            /* ⑤ */ $table->integer('first_author')->unsigned();

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
        Schema::dropIfExists('img_property');
    }
}
