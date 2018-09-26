<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    /**
     *  Полосность паркета
     */
    const GOODS_BANDING = [
        '1-полосный',
        '2-полосный',
        '3-полосный',
    ];

    /**
     * Порода дерева
     */
    const GOODS_SPECIES = [
        'Дуб'
    ];

    /**
     * Покрытие
     */

    const GOODS_COATING = [
        'Лак',
        'Масло'
    ];

    protected $fillable = [
        'name', 'code', 'description', 'picture'
    ];
}
