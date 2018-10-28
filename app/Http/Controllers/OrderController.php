<?php

namespace App\Http\Controllers;

use App\Shoppingcart;
use Illuminate\Http\Request,
    App\Delivery,
    App\Payment,
    App\Order,
    App\User,
    Darryldecode\Cart\CartCollection,
    Illuminate\Support\Facades\Redis,
    Illuminate\Support\Facades\Auth,
    Illuminate\Support\Carbon;

class OrderController extends Controller
{

    const ORDER_STATUS_NEW = 'NEW';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        dd(Auth::user());
        $items = [];

        $deliveries = Delivery::all();
        $payments = Payment::all();
        $sessionId = session()->getId();
        $ip = \Request::ip();
        $items = new CartCollection(json_decode(Redis::get('cart:' . $ip . ':content')));

        $title = 'Оформление заказа';
        view()->share('title', $title);
        return view('cart',
            [
                'deliveries' => $deliveries,
                'payments' => $payments,
                'items' => $items,
                'total' => Redis::get('cart:' . $ip . ':total')
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrder(Request $request)
    {
        $ip = \Request::ip();
        $errors = [];
        $data = $request->get('data');

        if (Auth::user() && Auth::user()->id) {
            $userId = Auth::user()->id;
        } else {
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];

            $user->save();
            if (!$user->id) {
                $errors['message'][] = 'Не удалось создать пользователя';
            } else {
                $userId = $user->id;
            }
        }

        // ------ add Cart -------- //
        $shoppingCart = new Shoppingcart;

        $shoppingCart->content = serialize(json_decode(Redis::get('cart:' . $ip . ':content')));
        $shoppingCart->save();

        $cartId = $shoppingCart->id;

        if (!$cartId) {
            $errors['message'][] = 'Корзина не сохранилась';
        }

        // ------ add Cart -------- //


        $order = new Order;

        $adress = $data['zip-code'] . '/' . $data['city'] . ', ' . $data['street'] . ', ' . $data['house'];


        $order->code = Carbon::parse(Carbon::now())->format('dmY') . '/' . rand();
        $order->status = Order::ORDER_STATUS_NEW;
        $order->basket_id = $cartId;
        $order->user_id = $userId;
        $order->delivery_id = $data['delivery'];
        $order->payment_id = $data['payment'];
        $order->sum = $data['sum'];
        $order->adress = $adress;
        $order->comment = 'comment';

        $order->save();

        if (!$order->id) {
            $errors['message'][] = 'Не удалось создать заказ';
        }

        if (empty($errors)) {
            \Cart::session($ip)->clear();
            Redis::del('cart:' . $ip . ':content');
            Redis::del('cart:' . $ip . ':total');
            Redis::del('cart:' . $ip . ':count');
            return redirect('/personal/order/order=' . $order->code);
        } else {
            return response()
                ->json([
                    'errors' => $errors
                ]);
        }

    }

    public function show(string $order_code)
    {
       $order = Order::where([['code', $order_code], ['user_id', Auth::user()->id]])->firstOrFail();

       $order['basket'] = $order->basket();
       $order['delivery'] = $order->delivery();
       $order['user'] = $order->user();
       $order['payment'] = $order->payment();

        return view('order',
            [
                $order => $order,
            ]);
    }
}
