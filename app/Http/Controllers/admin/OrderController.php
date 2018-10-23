<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request,
    App\Http\Controllers\Controller,
    App\Good,
    App\Sku,
    App\Order;

class OrderController extends Controller
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
        $orders = Order::all();
        foreach ($orders as $order) {
            $order['delivery'] = $order->delivery();
            $order['payment'] = $order->payment();
            $order['cart'] = $order->basket();
        }
        dd($orders);
        return view('admin.orders_show', ['orders' => $orders]);
    }
}
