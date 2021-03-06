<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request,
    App\Http\Controllers\Controller,
    App\Good,
    App\Sku;

class GoodsController extends Controller
{
    /**
     * @param string $good_article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $good_article)
    {
        $good = Good::findOrFail($good_article);
        $good['skus'] = $good->skus()->get();
        $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'big')->get();
        $json = [];
        foreach ($good['skus'] as $sku) {
            $json[$sku->id] = $sku;
        }
        return view('admin.good_edit', ['good' => $good, 'json' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
    }

    public function show()
    {
        $goods = Good::all();
        foreach ($goods as $good) {
            $good['skus'] = $good->skus()->orderBy('price')->get();
            $good['total'] = $good['skus']->sum('count');
        }

        return view('admin.goods_show', ['goods' => $goods, 'props_good' => Good::PROPERTIES_NAMES, 'props_sku' => Sku::PROPERTIES_NAMES]);
    }
}
