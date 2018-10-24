<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    const PROPERTIES_NAMES = [
        'brand' => 'Производитель',
        'base_color' => 'Основной цвет',
        'filler' => 'Наполнитель',
        'textile' => 'Ткань',
        'count_color' => 'Количество цветов',
        'article' => 'Артикул',
    ];

    protected $fillable = [
        'name', 'code', 'description', 'picture', 'price'
    ];

    protected $primaryKey = 'article';

    public $incrementing = false;

    public function skus()
    {
        return $this->hasMany(Sku::class, 'article')->orderBy('price');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'element');
    }
}
