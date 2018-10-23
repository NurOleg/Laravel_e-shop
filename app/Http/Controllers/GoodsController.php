<?php

namespace App\Http\Controllers;

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
    const PARAM_NAMES = [
        'pillowcase' => 'Наволочка',
        'duvet' => 'Одеяло',
        'sheet' => 'Простынь',
        'price' => 'Цена',
        'count' => 'Количество товара',
        'size' => 'Размер',
        'brand' => 'Производитель',
        'base_color' => 'Основной цвет',
        'filler' => 'Наполнитель',
        'textile' => 'Ткань',
        'count_color' => 'Количество цветов',
    ];

    /**
     * @param string $category_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $category_slug = '')
    {

//        if (!Cache::has('catalog' . $category_slug)) {
        if (!empty($category_slug)) {
            $categoryCurrent = Category::where('category_slug', $category_slug)->limit(1)->get();
            $title = $categoryCurrent[0]->name;
            $categoriesChildListForGoods = Category::descendantsOf($categoryCurrent[0]->id);
            $categoriesChildListForTree = Category::where('parent_id', $categoryCurrent[0]->id)->where('active', 1)->orderBy('synch_id')->get();

            if ($categoriesChildListForGoods->count() !== 0) {
                $childIds = [];
                foreach ($categoriesChildListForGoods as $childCategory) {
                    $childIds[] = $childCategory->id;
                }
                $goods = Good::where('active', 1)->whereIn('category_id', $childIds)->paginate(20);
            } else {
                $goods = Good::where('active', 1)->where('category_id', $categoryCurrent[0]->id)->paginate(20);
            }
        } else {
            $categoriesChildListForTree = Category::where('parent_id', null)->where('active', 1)->orderBy('synch_id')->get();
            $goods = Good::where('active', 1)->paginate(20);
            $title = 'Casa Flower Каталог';
        }
        foreach ($goods as $good) {
            $good['skus'] = $good->skus()->orderBy('price')->get();
            $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'little')->get();
        }
        // ????????? -------
        $filter = [];

        foreach ($goods as $good) {
            foreach ($good->skus as $sku) {
                if (!is_null($sku->pillowcase)) {
                    $filter['pillowcase'][] = $sku->pillowcase;
                }
                if (!is_null($sku->price)) {
                    $filter['price'][] = $sku->price;
                }
                if (!is_null($sku->duvet)) {
                    $filter['duvet'][] = $sku->duvet;
                }
                if (!is_null($sku->sheet)) {
                    $filter['sheet'][] = $sku->sheet;
                }
            }
        }
        foreach ($filter as $filterParam => $filterValue) {
            $filter[$filterParam] = array_unique($filter[$filterParam]);
            asort($filter[$filterParam]);
        }
        // ?????? -------------
//        }
        view()->share('title', $title);
        return view('catalog', ['categoriesTree' => $categoriesChildListForTree, 'goods' => $goods, 'filter' => $filter]);
    }

    /**
     * @param Request $request
     */
    public function ajaxFilter(Request $request)
    {

        $goods = Good::whereHas('skus', function ($q) {
            $q->where('sheet', '=', '220х240')
                ->where('pillowcase', '=', '4шт-50х70 (2шт), 70х70 (2шт)');

        })->where('active', 1)->limit(1)->get();
        dd($goods);
//        $resultHtml = view('catalog', ['categoriesTree' => $categoriesChildListForTree, 'goods' => $goods, 'filter' => $filter])->render();

//        echo response()->json(['result' => 'success', 'result' => $resultHtml]);
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
        \Cart::session($ip)->add($article, $name, 1500, (int)$count, $options);

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
