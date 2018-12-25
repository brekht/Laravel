<?php

/* Create by Xenial ~ artisan */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
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

    protected $table = 'category_articles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'article_id',
    ];

    #public $timestamps = false;

    protected $dates = [
        'created_at', 'updated_at'
    ];

    # ···································································

}
