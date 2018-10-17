<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request,
    App\Http\Controllers\Controller,
    App\Good;

class GoodsController extends Controller
{
    public function edit(string $good_article)
    {
        $good = Good::findOrFail($good_article);
        $good['skus'] = $good->skus()->get();
        $good['image'] = $good->images()->where('entity', Good::class)->where('size', 'big')->get();

        return view('admin.good_edit', ['good' => $good]);
    }
}
