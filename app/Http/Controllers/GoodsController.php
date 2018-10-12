<?php

namespace App\Http\Controllers;

use Doctrine\Common\Cache\ChainCache;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Http\Request,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Carbon,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Collection,
    App\Good,
    App\Category,
    Gloudemans\Shoppingcart\Facades\Cart;

class GoodsController extends Controller
{
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
                $good['skus'] = $good->skus()->get();
                $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'little')->get();
            }
            // ????????? -------
            $filter = [];

            foreach ($goods as $good) {
                foreach ($good->skus as $sku) {
                    if(!is_null($sku->pillowcase)) {
                        $filter['pillowcase'][] = $sku->pillowcase;
                    }
                    if(!is_null($sku->price)) {
                        $filter['price'][] = $sku->price;
                    }
                    if(!is_null($sku->duvet)) {
                        $filter['duvet'][] = $sku->duvet;
                    }
                    if(!is_null($sku->sheet)) {
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

    public function ajaxFilter(Request $request)
    {

                $goods = [];
        $skuWhere = [['sku.sheet', '=', '220х240'], ['sku.pillowcase', '=', '4шт-50х70 (2шт), 70х70 (2шт)']];

        $goodsRes = DB::table('goods')
            ->join('sku', 'goods.article', '=', 'sku.article')
            ->join('images', 'goods.article', '=', 'images.element')
            ->where('images.size', '=', 'little')
            ->where('images.entity', '=', Good::class)
            ->where($skuWhere)
            ->select('goods.*', 'sku.*', 'images.src')
            ->get();

        foreach ($goodsRes as $good) {
            $goods[$good->article]['name'] = $good->name;
            $goods[$good->article]['article'] = $good->article;
            $goods[$good->article]['skus'][] = $good->price;
            $goods[$good->article]['image'][] = $good->src;
        }

            $goods = collect($goods);
        foreach ($goods as $article => $good) {
            $goods[$article] = collect($goods[$article]);
        }
//        $resultHtml = view('catalog', ['categoriesTree' => $categoriesChildListForTree, 'goods' => $goods, 'filter' => $filter])->render();

//        echo response()->json(['result' => 'success', 'result' => $resultHtml]);
    }

    public function ajaxBasket(Request $request)
    {
        $article = $request->get('data')['data']['article'];
        $name = $request->get('data')['data']['name'];
        $options = $request->get('options')['options'];
        $count = $request->get('count')['count'];
        if(Cart::add($article, $name, $count, 1500, $options) instanceof CartItem) {
            echo Cart::content();die;
            echo response()->json(['result' => 'success', 'data' => []]);
        } else {
            echo response()->json(['result' => 'error', 'data' => 'Что-то пошло не так']);
        }
    }
}
