<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    Illuminate\Support\Facades\Redis,
    App\Good,
    App\Category;

class GoodsController extends Controller
{
    public function index($category_slug = 0)
    {
//        $categories = Category::all();
        $time = microtime(TRUE);
        $redis = Redis::connection();
        $redis->set('main_menu_tree', json_encode(Category::where('active', 1)->get()->toTree()));

//        $categoriesTree = Category::where('active', 1)->get()->toTree();
        dump(json_decode($redis->get('main_menu_tree')));

        print (microtime(TRUE)-$time). ' seconds';

//        return view('catalog', compact('categoriesTree'));
//        $categoryId = 0;
//        if ($category_code) {
//            foreach ($categories as $category) {
//                $categoryId = ($category->code === $category_code) ? : $category->id ;
//            }
//            $goods = Good::where('category_id', $categoryId)
//                ->firstOrFail()
//                ->paginate(20);
//        } else {
//            $goods = Good::all()
//                ->paginate(20);
//        }
//
//        foreach ($goods as $good) {
//            echo $good->id;
//        }
    }
}
