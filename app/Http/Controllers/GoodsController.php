<?php

namespace App\Http\Controllers;

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
    /**
     * @param string $category_slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(string $category_slug = '', Request $request)
    {
        $title = 'Casa Flower Каталог';
        $filterRequest = $request->get('filter');
        $goods = [];
        $categories = [];

        if (!empty($category_slug)) {
            $categoryCurrent = Category::where('category_slug', $category_slug)->limit(1)->get();
            $title = $categoryCurrent[0]->name;
            $categoriesChildListForGoods = Category::descendantsOf($categoryCurrent[0]->id);
            $categoriesChildListForTree = Category::where('parent_id', $categoryCurrent[0]->id)->where('active', 1)->orderBy('synch_id')->get();

            foreach ($categoriesChildListForGoods as $childCategory) {
                $categories[] = $childCategory->id;
            }

        } else {
            $categoriesChildListForTree = Category::where('parent_id', null)->where('active', 1)->orderBy('synch_id')->get();
        }


        if (!is_null($filterRequest)) {
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
            if (count($categories) > 1) {
                $goods = Good::whereHas('skus', function ($q) use ($whereSku) {
                    $q->where($whereSku);
                })->with(['skus' => function ($q) use ($whereSku) {
                    $q->where($whereSku);
                }])->where($whereGood)->whereIn('category_id', $categories);
            } elseif (count($categories) === 1) {
                $goods = Good::whereHas('skus', function ($q) use ($whereSku) {
                    $q->where($whereSku);
                })->with(['skus' => function ($q) use ($whereSku) {
                    $q->where($whereSku);
                }])->where($whereGood)->where('category_id', $categories[0]);
            } else {
                $goods = Good::whereHas('skus', function ($q) use ($whereSku) {
                    $q->where($whereSku);
                })->with(['skus' => function ($q) use ($whereSku) {
                    $q->where($whereSku);
                }])->where($whereGood);
            }
            $forFilter = $goods->get();
            $goodsRes = $goods->paginate(20);
            foreach ($goodsRes as $good) {
                $good['skus'] = $good->skus()->get();
                $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'little')->get();
            }
        } else {
            $forFilter = Good::where('active', 1)->get();
            if (!empty($categories)) {
                $goods = Good::whereIn('category_id', $categories)->paginate(20);
            } else {
                $goods = Good::paginate(20);
            }
            foreach ($goods as $good) {
                $good['skus'] = $good->skus()->get();
                $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'little')->get();
            }
        }

        foreach ($forFilter as $filterGood) {
            $filterGood['skus'] = $filterGood->skus()->get();
        }

        // ????????? -------
        $filter = [];

        foreach ($forFilter as $filterGood) {
            if (!is_null($filterGood->base_color) && is_string($filterGood->base_color)) {
                $filter['base_color'][] = $filterGood->base_color;
            }
            if (!is_null($filterGood->brand) && is_string($filterGood->brand)) {
                $filter['brand'][] = $filterGood->brand;
            }
            if (!is_null($filterGood->count_color) && is_string($filterGood->count_color)) {
                $filter['count_color'][] = $filterGood->count_color;
            }
            if (!is_null($filterGood->textile) && is_string($filterGood->textile)) {
                $filter['textile'][] = $filterGood->textile;
            }
            if (!is_null($filterGood->filler) && is_string($filterGood->filler)) {
                $filter['filler'][] = $filterGood->filler;
            }
            foreach ($filterGood->skus as $sku) {
                if (!is_null($sku->pillowcase) && $sku->pillowcase != '0') {
                    $filter['pillowcase'][] = $sku->pillowcase;
                }
                if (!is_null($sku->duvet) && $sku->duvet != '0') {
                    $filter['duvet'][] = $sku->duvet;
                }
                if (!is_null($sku->sheet) && $sku->sheet != '0') {
                    $filter['sheet'][] = $sku->sheet;
                }
                if (!is_null($sku->price)) {
                    $filter['price'][] = $sku->price;
                }
            }
        }
        foreach ($filter as $filterParam => $filterValue) {
            $filter[$filterParam] = array_unique($filter[$filterParam]);
            asort($filter[$filterParam]);
        }

        $json = [];

        foreach ($goods as $good)
        {
            $json[$good->article] = $good;
        }

        // ?????? -------------
//        }

        view()->share('title', $title);
        if (is_null($filterRequest)) {
            return view('catalog', [
                'categoriesTree' => $categoriesChildListForTree,
                'goods' => $goods,
                'filter' => $filter,
                'props' => array_merge(Good::PROPERTIES_NAMES, Sku::PROPERTIES_NAMES),
                'slug' => $category_slug,
                'json' => json_encode($json)
            ]);
        } else {
            $resultHtml = view('catalog_ajax',
                ['categoriesTree' => $categoriesChildListForTree,
                    'goods' => $goodsRes,
                    'filter' => $filter,
                    'props' => array_merge(Good::PROPERTIES_NAMES, Sku::PROPERTIES_NAMES),
                    'slug' => $category_slug
                ])->render();

            return response()->json(['result' => 'success', 'html' => $resultHtml, 'total' => $goodsRes->total()]);
        }
    }

    /**
     * @param Request $request
     * @throws \Throwable
     */
    public function ajaxFilter(Request $request)
    {

        $whereSku = [];
        $whereGood = [];
        $data = $request->get('filter');
        foreach ($data as $propName => $propValue) {
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
        }])->where($whereGood)->get();

        $filter = [];

        foreach ($goods as $filterGood) {
            if (!is_null($filterGood->base_color) && is_string($filterGood->base_color)) {
                $filter['base_color'][] = $filterGood->base_color;
            }
            if (!is_null($filterGood->brand) && is_string($filterGood->brand)) {
                $filter['brand'][] = $filterGood->brand;
            }
            if (!is_null($filterGood->count_color) && is_string($filterGood->count_color)) {
                $filter['count_color'][] = $filterGood->count_color;
            }
            if (!is_null($filterGood->textile) && is_string($filterGood->textile)) {
                $filter['textile'][] = $filterGood->textile;
            }
            if (!is_null($filterGood->filler) && is_string($filterGood->filler)) {
                $filter['filler'][] = $filterGood->filler;
            }
            foreach ($filterGood->skus as $sku) {
                if (!is_null($sku->pillowcase) && $sku->pillowcase != 0) {
                    $filter['pillowcase'][] = $sku->pillowcase;
                }
                if (!is_null($sku->duvet) && $sku->duvet != 0) {
                    $filter['duvet'][] = $sku->duvet;
                }
                if (!is_null($sku->sheet) && $sku->sheet != 0) {
                    $filter['sheet'][] = $sku->sheet;
                }
                if (!is_null($sku->price)) {
                    $filter['price'][] = $sku->price;
                }
            }
        }
        foreach ($filter as $filterParam => $filterValue) {
            $filter[$filterParam] = array_unique($filter[$filterParam]);
            asort($filter[$filterParam]);
        }

        dd($goods);
        $resultHtml = view('catalog', ['categoriesTree' => $categoriesChildListForTree, 'goods' => $goods, 'filter' => $filter])->render();

        echo response()->json(['result' => 'success', 'result' => $resultHtml]);
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
    public function detail(string $good_article)
    {
        $good = Good::findOrFail($good_article);
        $title = $good->name;
        $good['skus'] = $good->skus()->get();
        $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'big')->get();

        view()->share('title', $title);
        return view('catalog_detail', ['good' => $good]);

    }
}
