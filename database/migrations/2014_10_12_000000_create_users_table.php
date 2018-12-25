<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Для Поля `id` Первичный autoincrement ключ (беззнаковый) - укажем (беззнаковый)
     *  ② ! Поле `name` для Таблицы `users` нам не понадобиться!
     *  ③ Для Поля `email` укажем, что Поле должно быть уникальное и что Поле не должно быть более 128
     *  ④ Для Поля `password` укажем, что Поле не должно быть более 128
     *  ⑤ Нам понадобиться Поле TINYINT `isAdmin` ~ создадим его: по дефолту, Значение будет 0, т.е. не Админ
     *  ⑥ Поле TINYINT `root`: и также нам нужно предусмотреть возможность разделения прав нескольких Администраторов
     *      где у root будут полные права (по дефолту, Значение нет, т.е. NULL, т.е. не root, иначе 1-н root)
     *  ⑦ Поле TINYINT `isConfirm`: и также, после регистрации, пользователь сразу будет подтверждён,
     *      т.е. по дефолту `isConfirm` со Значением 1, однако предусмотрим возможноть
     *      заблокировать Пользователя, указав в последствии для `isConfirm` Значением 0-ноль
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`users` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `email` VARCHAR(128) NOT NULL,
     *    `password` VARCHAR(128) NOT NULL,
     *    `isAdmin` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
     *    `root` TINYINT(1) UNSIGNED NULL,
     *    `isConfirm` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
     *    PRIMARY KEY (`id`),
     *    UNIQUE INDEX `email_UNIQUE` (`email` ASC))
     *  ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned(); # id, с Primary Key и autoincrement
            /* ② */ #$table->string('name');
            /* ③ */ $table->string('email', 128)->unique();
            /* ④ */ $table->string('password', 128);
            /* ⑤ */ $table->tinyInteger('isAdmin')->unsigned()->default(0);
            /* ⑥ */ $table->tinyInteger('root')->unsigned()->nullable();
            /* ⑦ */ $table->tinyInteger('isConfirm')->unsigned()->default(1);

            $table->rememberToken(); # Токен для восстановления пароля
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
