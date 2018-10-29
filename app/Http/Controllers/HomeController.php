<?php

namespace App\Http\Controllers;

use App\Good,
    App\Sku,
    App\Services\CategoryService,
    Illuminate\Support\Facades\Cache,
    Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $categoryService;

    /**
     * HomeController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->categoryService = new CategoryService();
    }

    /**
     * @param Good $good
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Good $good)
    {
        if (!Cache::has('home')) {
            $topGoods = [];
            $json = [];
            $data = [];
            $topGoods['sales'] = $good->getTop('sales');
            $topGoods['hits'] = $good->getTop('hits');
            $topGoods['featured'] = $good->getTop('featured');

            // Make json, make url
            foreach (Good::PROPERTIES_NAMES['propsForTops'] as $code => $val) {
                foreach ($topGoods[$code] as $good) {
                    $good['url'] = $this->categoryService->makeItemUrl($good->category_id, $good->article, 'catalog');

                    $json[$good->article] = $good;
                }
            }

            $dataToCache = [
                'topGoods' => $topGoods,
                'props' => array_merge(Good::PROPERTIES_NAMES, Sku::PROPERTIES_NAMES),
                'json' => json_encode($json),
            ];

            $expiresAt = now()->addDays(7);

            Cache::add('home', $dataToCache, $expiresAt);
        }
        $data = Cache::get('home');

        return view('home', $data);
    }
}
