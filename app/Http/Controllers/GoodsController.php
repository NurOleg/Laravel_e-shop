<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Carbon,
    App\Good,
    App\Category;

class GoodsController extends Controller
{
    /**
     * @param int $category_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category_slug = 0)
    {
        if (!Cache::has('catalog_menu_tree')) {
            $categories = Category::where('active', 1)->orderBy('id', 'asc')->get()->toTree();
//            $categories = Category::withDepth()->having('depth', '=', 1)->get();
            $expiresAt = Carbon::now()->addMinutes(1440 * 30);
            Cache::put('catalog_menu_tree', $categories, $expiresAt);
        }
//        $categories = Category::whereIsRoot()->get();
        $categoriesTree = Cache::get('catalog_menu_tree');

        return view('catalog', ['categoriesTree' => $categoriesTree]);
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

//    public function delete()
//    {
//        $sectionsToDelete = [
//            128, 78, 117, 109, 185, 239, 191, 76, 8, 227, 3, 242, 11, 112
//        ];
//        foreach ($sectionsToDelete as $sectionToDelete) {
//            $node = Category::find($sectionToDelete);
//            $node->delete();
//        }
//    }
}
