<?php

namespace App\Providers;

use App\Category,
    Illuminate\Support\Carbon,
    Illuminate\Support\Facades\Cache,
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
