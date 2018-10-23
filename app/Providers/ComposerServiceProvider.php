<?php

namespace App\Providers;

use App\Category,
    Illuminate\Support\Carbon,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Facades\Redis,
    Darryldecode\Cart\CartCollection,
    Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.main_menu', function ($view) {
            if (!Cache::has('home_catalog_tree')) {
                $catalogCategories = Category::where('parent_id', null)
                    ->where('active', 1)
                    ->orderBy('synch_id')
                    ->get();
                $expiresAt = Carbon::now()->addMinutes(1440 * 30);
                Cache::put('home_catalog_tree', $catalogCategories, $expiresAt);
            }
            $catalogCategories = Cache::get('home_catalog_tree');

            $view->catalogCategories = $catalogCategories;
        });

        view()->composer('partials.header_cart', function ($view) {
            $ip = \Request::ip();

            $cart = json_decode(Redis::get('cart:' . $ip . ':content'));
            $count = Redis::get('cart:' . $ip . ':count');
            $total = Redis::get('cart:' . $ip . ':total');

            $view->cart = $cart;
            $view->total = $total;
            $view->count = $count;

        });

        view()->composer('admin.partials.category_menu', function ($view) {
            if (!Cache::has('admin_categories_tree')) {
                $categoriesTree = Category::get()->toTree();
                $expiresAt = Carbon::now()->addSeconds(1);
                Cache::put('admin_categories_tree', $categoriesTree, $expiresAt);
            }

            $categoriesMenu = Category::get()->toTree();
            $view->categoriesMenu = $categoriesMenu;

        });

        view()->share('title', 'CasaFlower E-shop');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
