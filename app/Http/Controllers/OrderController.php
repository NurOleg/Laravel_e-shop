<?php

namespace App\Http\Controllers;

use App\Shoppingcart;
use Illuminate\Http\Request,
    Illuminate\Session,
    App\Delivery,
    App\Payment,
    App\Order,
    App\User,
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
        $items = [];

        $deliveries = Delivery::all();
        $payments = Payment::all();
        $sessionId = session()->getId();
        $items = \Cart::session($sessionId)->getContent();

        $title = 'Оформление заказа';
        view()->share('title', $title);
        return view('cart',
            [
                'deliveries' => $deliveries,
                'payments' => $payments,
                'items' => $items,
                'total' => \Cart::session($sessionId)->getTotal()
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrder(Request $request)
    {
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

        $sessionId = session()->getId();
        $shoppingCart->content = serialize(\Cart::session($sessionId)->getContent());

        $cartId = $shoppingCart->id;

        if (!$cartId) {
            $errors['message'][] = 'Корзина не сохранилась';
        }

        // ------ add Cart -------- //


        $order = new Order;

        $order->code = Carbon::parse(Carbon::now())->format('dmY') . '/' . rand();

        $order->status = Order::ORDER_STATUS_NEW;

        $order->basket_id = $cartId;
        $order->user_id = $userId;
        $order->delivery_id = $data['delivery_id'];
        $order->payment_id = $data['payment_id'];
        $order->sum = $data['sum'];
        $order->comment = $data['comment'];

        $order->save();

        if (!$order->id) {
            $errors['message'][] = 'Не удалось создать заказ';
        }

        if (empty($errors)) {
            redirect('/personal/order/' . $order->id);
        } else {
            return response()
                ->json([
                    'errors' => $errors
                ]);
        }

    }
}
