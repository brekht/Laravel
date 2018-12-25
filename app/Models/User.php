<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    #
    use Notifiable;

    # явно указываем наименование Таблицы, с которой будет работать Модель User
    protected $table = "users";
    # явно указываем Primary Key
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        # что нам разрешено добавлять в Action-е create() Контроллера RegisterController
        /*'name',*/ 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    # Указываем Касты (Мутаторы): нужны когда мы приводим - определённую Колонку в нашей Таблице - к определённому типу,
    # например, мы можем привести Поля created_at и updated_at - к типу DATETIME
    # и тогда сам Фреймворк позволит нам модифицировать эту дату - прямо через Объект,
    # т.е. нам не нужно будет делать какие-то преобразования
    # ! т.е. мы просто указываем явные типы наших Полей (которые были указаны в Миграциях, при создании Таблиц)
    protected $casts = [
        'id'                => 'integer',
        'email'             => 'string',
        'password'          => 'string',
        'isAdmin'           => 'boolean',
        'root'              => 'boolean',
        'isConfirm'         => 'boolean',
        'remember_token'    => 'string',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime'
    ];

    # (Также Мутаторы) Переопределим Свойство $dates - т.е. нам нужно указать явно наши даты, т.е. всё, что DATETIME
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    # и опять же, с данными Мутаторами - нам удобно будет работать через Объект, например с той же Датой,
    # и не нужно будет её преобразовывать через PHP функцию какой-нибудь string to date
    # Пакет Фреймворку Carbon будет это делать за нас

}
