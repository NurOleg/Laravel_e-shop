<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Sku;
use Doctrine\Common\Cache\ChainCache,
    Illuminate\Http\Request,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Carbon,
    Illuminate\Support\Facades\DB,
    Illuminate\Session,
    App\Good,
    App\Category;

class GoodsController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = new CategoryService();
    }

    /**
     * @param string $category_slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(string $category_slug = '', Request $request)
    {
        $title = 'Каталог товаров для сна | Интернет магазин "Ловец снов"';
        $filterRequest = $request->get('filter');
        $page = ($request->ajax()) ? $request->get('page') : null;
        $goodsFilterProps = Good::PROPERTIES_NAMES['filterable'];
        $skusFilterProps = Sku::PROPERTIES_NAMES['filterable'];

        $categoriesForFilter = $this->categoryService->getCatalogCategoriesForFilter($category_slug);
        $categoriesTree = $this->categoryService->getCatalogCategories($category_slug);

        if ($request->ajax()) {
            $whereGood = [];
            $whereSku = [];
            foreach ($filterRequest as $propName => $propValue) {
                if ($propName == 'price_from') {
                    $whereSku[] = ['price', '>=', (int)$propValue];
                    continue;
                }
                if ($propName == 'price_to') {
                    $whereSku[] = ['price', '<', (int)$propValue];
                    continue;
                }
                if (array_key_exists($propName, Sku::PROPERTIES_NAMES)) {
                    $whereSku[] = [$propName, $propValue];
                } else {
                    $whereGood[] = [$propName, $propValue];
                }
            }

            $goods = Good::whereHas('skus', function ($q) use ($whereSku) {
                $q->where($whereSku);
            })->with(['skus' => function ($q) use ($whereSku) {
                $q->where($whereSku);
            }])->where($whereGood);


            $goods = (!empty($categoriesForFilter)) ?
                $goods->whereIn('category_id', $categoriesForFilter)->where('active', 1)
                :
                $goods->where('active', 1);

        } else {
            $goods = (!empty($categoriesForFilter)) ?
                Good::whereIn('category_id', $categoriesForFilter)->where('active', 1)
                :
                Good::where('active', 1);
        }

        $forFilter = $goods->get();
        $goods = (!is_null($page)) ? $goods->skip($page * 20)->take(20)->paginate(20) : $goods->paginate(20);


        foreach ($goods as $good) {
            $good['skus'] = $good->skus()->get();
            $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'little')->get();
            $good['url'] = $this->categoryService->makeItemUrl($good->category_id, $good->article, 'catalog');
        }

        foreach ($forFilter as $filterGood) {
            $filterGood['skus'] = $filterGood->skus()->get();
        }

        // ????????? -------
        $filter = [];

        foreach ($forFilter as $filterGood) {
            if (!is_null($filterGood->brand) && is_string($filterGood->brand)) {
                $filter['brand'][] = $filterGood->brand;
            }
            if (!is_null($filterGood->base_color) && is_string($filterGood->base_color)) {
                $filter['base_color'][] = $filterGood->base_color;
            }
            if (!is_null($filterGood->filler) && is_string($filterGood->filler)) {
                $filter['filler'][] = $filterGood->filler;
            }
            if (!is_null($filterGood->textile) && is_string($filterGood->textile)) {
                $filter['textile'][] = $filterGood->textile;
            }
            if (!is_null($filterGood->count_color) && is_string($filterGood->count_color)) {
                $filter['count_color'][] = $filterGood->count_color;
            }
            foreach ($filterGood->skus as $sku) {
                if (!is_null($sku->pillowcase) && $filterGood->pillowcase != '0') {
                    $filter['pillowcase'][] = $sku->pillowcase;
                }
                if (!is_null($sku->duvet) && $filterGood->duvet != '0') {
                    $filter['duvet'][] = $sku->duvet;
                }
                if (!is_null($sku->sheet) && $filterGood->sheet != '0') {
                    $filter['sheet'][] = $sku->sheet;
                }
                if (!is_null($sku->size) && $filterGood->size != '0') {
                    $filter['size'][] = $sku->size;
                }
                if (!is_null($sku->price) && $filterGood->price != '0') {
                    $filter['price'][] = $sku->price;
                }
            }
        }
        foreach ($filter as $filterParam => $filterValue) {
            $filter[$filterParam] = array_unique($filter[$filterParam]);
            asort($filter[$filterParam]);
        }
        $json = [];

        foreach ($goods as $good) {
            $json[$good->article] = $good;
        }

        // ?????? -------------
//        }
        view()->share('title', $title);
        if (!$request->ajax()) {
            return view('catalog', [
                'categoriesTree' => $categoriesTree,
                'goods' => $goods,
                'filter' => $filter,
                'props' => array_merge($goodsFilterProps, $skusFilterProps),
                'slug' => $category_slug,
                'json' => json_encode($json)
            ]);
        } else {
            $resultHtml = view('catalog_ajax',
                ['categoriesTree' => $categoriesTree,
                    'goods' => $goods,
                    'filter' => $filter,
                    'props' => array_merge($goodsFilterProps, $goodsFilterProps),
                    'slug' => $category_slug,
                    'json' => json_encode($json)
                ])->render();

            return response()->json(['result' => 'success', 'html' => $resultHtml, 'total' => $goods->total()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxBasket(Request $request)
    {
        $article = $request->get('data')['data']['article'];
        $name = $request->get('data')['data']['name'];
        $options = $request->get('options')['options'];
        $count = $request->get('count')['count'];
        $price = $request->get('price');

        $ip = \Request::ip();
        if (Redis::get('cart:' . $ip . ':content')) {
            foreach (json_decode(Redis::get('cart:' . $ip . ':content'), true) as $item) {
                $qnt = $item['quantity'];
                if ($item['id'] == $article) {
                    $qnt = $item['quantity']++;
                }
                \Cart::session($ip)->add($item['id'], $item['name'], $item['price'], $qnt, $item['attributes']);
            }

        }
        \Cart::session($ip)->add($article, $name, (int)$price, (int)$count, $options);

        Redis::set('cart:' . $ip . ':content', \Cart::session($ip)->getContent());
        Redis::set('cart:' . $ip . ':total', \Cart::session($ip)->getTotal());
        Redis::set('cart:' . $ip . ':count', \Cart::session($ip)->getContent()->count());
        return response()
            ->json([
                'result' => 'success',
                'cart' => Redis::get('cart:' . $ip . ':content'),
                'total' => Redis::get('cart:' . $ip . ':total'),
                'count' => Redis::get('cart:' . $ip . ':count')
            ]);

    }

    /**
     * @param string $good_article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(string $category = '', string $child_category_slug = '', string $subchild_category_slug = '', string $good_article)
    {
        $good = Good::findOrFail($good_article);
        $title = $good->name;
        $good['skus'] = $good->skus()->get();
        $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'big')->get();

        view()->share('title', $title);
        return view('catalog_detail', ['good' => $good]);

    }
}
