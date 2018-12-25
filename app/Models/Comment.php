<?php

/* Create by Xenial ~ artisan */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    static $_instance;

    public static function getInstance() {
        if(!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    private function __clone() {}
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # ···································································

    protected $table = 'comments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'article_id',
        'user_id',
        'status',
        'comment'
    ];

    # !!! Связь данной Таблицы `comments` и Таблицы `articles` - описана в Модели Article, как Связь hasMany()
    # т.е. Один ко многии (Одна Статья, и у неё может быть много Комментариев (соответственно и от разных Пользователей)) !!!

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    # ···································································
}
