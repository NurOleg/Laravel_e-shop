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
     * @param int $order_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order['delivery'] = $order->delivery();
        $order['payment'] = $order->payment();
        $order['user'] = $order->user();
        $order['cart'] = unserialize($order->basketJson()[0]->content);
        dd($order['cart']);
        return view('admin.order_edit', ['order' => $order, 'props' => Order::ORDER_PROPERTIES]);
    }

    public function show()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $order['delivery'] = $order->delivery();
            $order['payment'] = $order->payment();
            $order['user'] = $order->user();
            $order['cart'] = unserialize($order->basketJson()[0]->content);
        }

        return view('admin.orders_show', ['orders' => $orders, 'props' => Order::ORDER_PROPERTIES]);
    }
}
