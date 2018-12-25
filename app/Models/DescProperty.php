<?php

/* Create by Xenial ~ artisan */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DescProperty extends Model
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

    protected $table = 'desc_property';
    protected $primaryKey = 'id';

    # 'что мы будем массово заполнять'
    protected $fillable = [
        'desc',
        'essences_id',
        'user_id',
        'first_author'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    # ···································································
}
