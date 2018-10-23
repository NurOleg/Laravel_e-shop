<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    const PROPERTIES_NAMES = [
        'pillowcase' => 'Наволочка',
        'duvet' => 'Одеяло',
        'sheet' => 'Простынь',
        'price' => 'Цена',
        'count' => 'Количество товара',
        'size' => 'Размер',
    ];
    protected $table = 'sku';

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
