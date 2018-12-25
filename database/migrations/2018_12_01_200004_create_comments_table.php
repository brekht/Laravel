<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     *
     *  ② Инициируем Поле `status`, как TINYINT, со Значением по-умолчанию 'FALSE'
     *      т.к. у MySQL нет типа Поля boolean() - Laravel переведёт это Поле в TINYINT
     *      Значение по-умолчанию для Поля как 'FALSE'
     *      Если FALSE значит 0, т.е. Статья будет на модерации и не опубликована
     *      Если TRUE значит 1, т.е. Статья прошла модерацию, и опубликована
     *      В итоге, по-умолчанию все Комментарии будут не опубликованы, т.е. должны будут пройти модерацию
     *      ! Однако, сразу инициализируем Поле как TINYINT !
     *
     *  ③ Инициируем Поле `comment`, как Поле VARCHAR, длинной 255 символов,
     *      т.к. у Laravel нет возможности указать тип Поля TINYTEXT (который также 255 символов)
     *
     *  ④ Инициируем Поле `article_id`, как Поле INT (беззнаковое), как Внешний Ключ к Полю `id` Таблицы `articles`
     *      id той Статьи, к которой относиться текущий Комментарий Поля `comment`
     *
     *  ⑤ Инициируем Поле `user_id`, как Поле INT (беззнаковое), как Внешний Ключ к Полю `id` Таблицы `users`
     *      Кто оставил Комментарий
     *
     *  ⑥ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     *
     *  ④ и ⑤ : Инициализируя Внешние Ключи, нужно помнить, что при удалении, Записи в Таблице,
     *           где id удаляемой Записи - выступает как Внешний Ключ в связывающей Таблице,
     *           процесс удаления может завершиться неудачей, т.к. будет нарушена целостьность БД:
     *
     *           SQLSTATE[23000]: Integrity constraint violation:
     *           1451 Cannot delete or update a parent row:
     *           a foreign key constraint fails (`nature`.`category_articles`, CONSTRAINT `category_articles_article_id_foreign`
     *           FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`)) (SQL: delete from `articles` where `id` = 11)
     *
     *           Для реализации возможности использовать Внешние Ключи, и возможности удаления записи,
     *           id которой выступает как Внешний Ключ в связывающей Таблице,
     *           при указании Внешних связей в Миграции Laravel,
     *           также нужно указать Метод onDelete('cascade') с Параметром 'cascade'
     *
     *           И уже в дальнейшем, при реализации Логики удаления, выстраивать Логику таким образом,
     *           что мы, в зависимости от удаляемых данных, либо удаляем все взаимосвязанные данные,
     *           придупредив при этом Пользователя, либо в зависимости от условий, не выполняем удаление,
     *           уведомив Пользователя о том, какие данные потеряют свою целостность!
     *
     *
     *           ################################################################
     *
     *           Например, удалив Статью из Таблицы `articles`,
     *           также будет удалена связанная запись в Таблице `comments`, плюс связанная запись в Таблице `category_articles`
     *
     *           или удалив Пользователя из Таблицы `users`,
     *           также будет удалена связанная запись в Таблице `comments`,
     *
     *           и в том и в другом случае, мы теряем Внешние Ключи в Таблице `comments`,
     *           т.к. фактически сами саписи в Таблице `comments` относящиеся по Внешним Ключам к Таблицам `articles` или `users`
     *           сами записи в Таблице `comments` будут удалены
     *
     *           Однако, и в том и в другом случае, целостность не будет нарушена,
     *           т.к. при удалении Пользователя или Статьи, Комментарий (сапись в Таблице `comments`) будет удалён.
     *
     *           Но при удалении самого Комментария, Статья к которой написан Комментарий - удалена не будет,
     *           также при удалении Комментария, не будет удалён и Пользователь, который этот Комментарий написал
     *
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`comments` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
     *    `comment` TINYTEXT NOT NULL,  -- чтобы не инициализировать VARCHAR(255), мы просто инициализируем TINYTEXT, что равносильно VARCHAR(255)
     *    `article_id` INT UNSIGNED NOT NULL,
     *    `user_id` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`),
     *    INDEX `fk_comments_articles_idx` (`article_id` ASC),
     *    INDEX `fk_comments_users_idx` (`user_id` ASC),
     *    CONSTRAINT `fk_comments_articles`
     *      FOREIGN KEY (`article_id`)
     *      REFERENCES `nature`.`articles` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION,
     *    CONSTRAINT `fk_comments_users`
     *      FOREIGN KEY (`user_id`)
     *      REFERENCES `nature`.`users` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION)
     *  -- ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();

            /* ② */ $table->tinyInteger('status')->unsigned()->default(0);
            /* ③ */ $table->string('comment', 255);

            /* ④ */ $table->integer('article_id')->unsigned();
                     $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            /* ⑤ */ $table->integer('user_id')->unsigned();
                     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('comments');
    }
}
