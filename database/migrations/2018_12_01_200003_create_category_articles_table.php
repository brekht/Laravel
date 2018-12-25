<?php

/* Create by Xenial ~ artisan */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /* ⚑
     * --------------------------------------------------------------------------
     *  ① Инициируем Поле `id`, как Первичный autoincrement ключ (беззнаковый)
     *  ② Инициируем Поле `category_id`, как Поле INT (беззнаковое), как Внешний Ключ к Полю `id` Таблицы `categories`
     *  ③ Инициируем Поле `article_id`, как Поле INT (беззнаковое), как Внешний Ключ к Полю `id` Таблицы `articles`
     *  ④ Инициируем default Поле `created_at` и `updated_at` как Поле TIMESTAMP
     *
     *  ② и ③ : Инициализируя Внешние Ключи, нужно помнить, что при удалении, Записи в Таблице,
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
     *           Например, удалив все Категории из Таблицы `categories`,
     *           также будут удалены все связанные записи в Таблице `category_articles`,
     *           при этом, будут потеряны Внешние Ключи Таблицы `category_articles` к Таблице `articles`,
     *           целостность данных будет нарушена, т.к. мы теряем связь Таблиц `category_articles` и `articles`
     *           ! Соответственно, потребуется логика - на запрет на удаление Категории, если Категория выбрана к Статье!
     *
     *           Или, удалив все Статьи из Таблицы `articles`,
     *           также будут удалены все связанные записи в Таблице `category_articles`,
     *           при этом, будут потеряны Внешние Ключи Таблицы `category_articles` к Таблице `categories`,
     *           но целостность данных нарушена не будет, т.к. Таблица `categories` - выступает как Таблица Родитель
     *           для данных в Таблице `category_articles, а формирование Таблицы `category_articles`
     *           происходит при работе с Таблицей `articles`
     *
     * --------------------------------------------------------------------------
     *
     *
     *  CREATE TABLE IF NOT EXISTS `nature`.`category_articles` (
     *    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     *    `category_id` INT UNSIGNED NOT NULL,
     *    `article_id` INT UNSIGNED NOT NULL,
     *    PRIMARY KEY (`id`),
     *    INDEX `fk_category_articles_categories_idx` (`category_id` ASC),
     *    INDEX `fk_category_articles_articles_idx` (`article_id` ASC),
     *    CONSTRAINT `fk_category_articles_categories`
     *      FOREIGN KEY (`category_id`)
     *      REFERENCES `nature`.`categories` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION,
     *    CONSTRAINT `fk_category_articles_articles`
     *      FOREIGN KEY (`article_id`)
     *      REFERENCES `nature`.`articles` (`id`)
     *      ON DELETE NO ACTION
     *      ON UPDATE NO ACTION)
     *  -- ENGINE = InnoDB
     *  DEFAULT CHARACTER SET = utf8;
     *
     */

    public function up()
    {
        Schema::create('category_articles', function (Blueprint $table) {
            /* ① */ $table->increments('id')->unsigned();

            /* ② */ $table->integer('category_id')->unsigned();
                     $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            /* ③ */ $table->integer('article_id')->unsigned();
                     $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            /* ④ */ $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_articles');
    }
}
