<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    const PROPERTIES_NAMES = [
        'filterable' => [
            'pillowcase' => 'Наволочка',
            'duvet' => 'Одеяло',
            'sheet' => 'Простынь',
            'size' => 'Размер',
            'price' => 'Цена',
        ],

        'count' => 'Количество товара',
    ];
    protected $table = 'sku';

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
