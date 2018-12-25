<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreepropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     * ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     * ② Инициируем Поле `col_prop`, как varchar 100 символов
     * ③ Инициируем Поле `col_desc`, как varchar 100 символов
     * ④ Инициируем Поле `essences_id`, как Поле INT (беззнаковое), как Внешний Ключ к Полю `id` Таблицы `essences`
     * ⑤ Инициируем Поле `user_id`, как INT, беззнаковое
     * ⑥ Инициируем Поле `first_author`, как INT, беззнаковое
     * ⑦ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`freeproperties` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `col_prop` VARCHAR(100) NOT NULL,
     *    `col_desc` VARCHAR(100) NOT NULL,
     *    `essences_id` INT UNSIGNED NOT NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    `first_author` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`),
     *    INDEX `fk_fp_essences_idx` (`essences_id` ASC),
     *    CONSTRAINT `fk_fp_essences`
     *      FOREIGN KEY (`essences_id`)
     *      REFERENCES `nature`.`essences` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION)
     *  -- ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('freeproperties', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();
            /* ② */ $table->string('col_prop', 100);
            /* ③ */ $table->string('col_desc', 100);

            /* ④ */ $table->integer('essences_id')->unsigned();
                     $table->foreign('essences_id')->references('id')->on('essences')->onDelete('cascade');

            /* ⑤ */ $table->integer('user_id')->unsigned();

            /* ⑥ */ $table->integer('first_author')->unsigned();

            /* ⑦ */ $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freeproperties');
    }
}
