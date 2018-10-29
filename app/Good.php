<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    const PROPERTIES_NAMES = [
        'filterable' => [
            'brand' => 'Производитель',
            'base_color' => 'Основной цвет',
            'filler' => 'Наполнитель',
            'textile' => 'Ткань',
            'count_color' => 'Количество цветов',
        ],
        'propsForTops' => [
            'sales' => 'Акции',
            'hits' => 'Хиты продаж',
            'featured' => 'Рекомендуем'
        ],
        'article' => 'Артикул',
    ];

    protected $fillable = [
        'name', 'code', 'description', 'picture', 'price'
    ];

    protected $primaryKey = 'article';

    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skus()
    {
        return $this->hasMany(Sku::class, 'article')->orderBy('price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'element');
    }

    /**
     * @param string $propToFilter
     * @param int $limit
     * @return mixed
     */
    public function getTop(string $propToFilter = '', int $limit = 20)
    {
        $items = Good::where($propToFilter, 1)->limit($limit)->get();
        foreach ($items as $item) {
            $item['skus'] = $item->skus()->get();
            $item['image'] = $item->images()->where('entity', Good::class)->where('size', 'little')->get();
        }
        return $items;
    }
}
