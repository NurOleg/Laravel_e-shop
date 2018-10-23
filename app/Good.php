<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    const PROPERTIES_NAMES = [
//        'pillowcase' => 'Наволочка',
//        'duvet' => 'Одеяло',
//        'sheet' => 'Простынь',
//        'price' => 'Цена',
//        'count' => 'Количество товара',
//        'size' => 'Размер',
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
        return $this->hasMany(Sku::class, 'article')->orderBy('price')->get();
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'element');
    }

    /**
     * @param int $good_article
     * @param array $prices
     * @return array
     */
    public function getPricesForOne(int $good_article, array $prices = [])
    {
        foreach (Sku::select('price')->where([['article', '=', $good_article], ['count', '>', 0]])->get() as $price) {
            $prices[] = $price;
        }
        return $prices;
    }

    /**
     * @param array $good_article
     * @param array $prices
     * @return array
     */
    public function getPricesForMultiply(array $good_article, array $prices = [])
    {
        foreach (Sku::select('price')->whereIn('article', $good_article)->where('count', '>', 0)->get() as $price) {
            $prices[] = $price;
        }
        return $prices;
    }

    public function getPrices($good_article)
    {
        return is_array($good_article) ? $this->getPricesForMultiply($good_article) : $this->getPricesForOne($good_article) ;
    }
}
