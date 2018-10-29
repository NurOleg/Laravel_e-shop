<?php

namespace App\Services;

use App\Category;
use Kalnoy\Nestedset\Collection;

class CategoryService
{

    /**
     * @param string $slug
     * @return array $categories
     */
    public function getCatalogCategoriesForFilter(string $slug = '')
    {
        $categories = [];
        if ($slug !== '') {
            $currentCategory = Category::where([['category_slug', $slug], ['active', 1]])->limit(1)->get();
            $categoriesByParent = Category::defaultOrder()->descendantsOf($currentCategory[0]->id);
            foreach ($categoriesByParent as $category) {
                $categories[] = $category->id;
            }
        }
        return $categories;
    }

    /**
     * @param string $slug
     * @return Collection
     */
    public function getCatalogCategories(string $slug = '')
    {
        if ($slug === '') {
            $categoriesTree = Category::where([['parent_id', null], ['active', 1]])->get();
        } else {
            $currentCategory = Category::where([['category_slug', $slug], ['active', 1]])->limit(1)->get();
            $categoriesTree = Category::where('active', 1)->descendants($currentCategory[0]->id);
        }
        return $categoriesTree;
    }

    /**
     * @param int $categoryId
     * @param string $itemSlug
     * @param string $section
     * @return string
     */
    public function makeItemUrl(int $categoryId, string $itemSlug = '', string $section = '')
    {
        $url = '/' . $section . '/';
        $categories = Category::defaultOrder()->ancestorsAndSelf($categoryId);

        foreach ($categories as $category) {
            $url .= $category->category_slug . '/';
        }

        return $url . $itemSlug;
    }

}