<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache,
    App\Category;

class CategoryService
{
    /**
     * @param string $slug
     * @param array $categories
     * @return array
     */
    public function getCategoriesBySlug(string $slug, $categories = [])
    {
        if (!Cache::has('categories_' . $slug)) {
            if (!empty($slug)) {
                $categoryCurrent = Category::where('category_slug', $slug)->limit(1)->get();
                $title = $categoryCurrent[0]->name;
                $categoriesChildListForGoods = Category::descendantsOf($categoryCurrent[0]->id);
                $categoriesChildListForTree = Category::where('parent_id', $categoryCurrent[0]->id)->where('active', 1)->orderBy('synch_id')->get();

                if ($categoriesChildListForGoods->count() !== 0) {
                    $childIds = [];
                    foreach ($categoriesChildListForGoods as $childCategory) {
                        $childIds[] = $childCategory->id;
                    }
                } else {
                    $goods = Good::where('active', 1)->where('category_id', $categoryCurrent[0]->id)->paginate(20);
                }
            } else {
                $categoriesChildListForTree = Category::where('parent_id', null)->where('active', 1)->orderBy('synch_id')->get();
            }

        }

        $categories = Cache::get('categories_' . $slug)
        return $categories;
    }
}