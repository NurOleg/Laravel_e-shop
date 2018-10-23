<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ORDER_STATUS_NEW = 'NEW';
    const ORDER_STATUS_ACCEPTED = 'ACCEPTED';
    const ORDER_STATUS_CLOSED = 'CLOSED';
    const ORDER_PROPERTIES = [
        'statuses' => [
            self::ORDER_STATUS_NEW => 'Новый',
            self::ORDER_STATUS_ACCEPTED => 'Принятый',
            self::ORDER_STATUS_CLOSED => 'Завершенный',
        ],
        'sum' => 'Сумма заказа',
        'basket' => 'Корзина',
        'code' => 'Номер заказа',
        'status' => 'Статус заказа',
        'adress' => 'Адрес доставки'
    ];
    //

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->get();
    }

    /**
     * @return string
     */
    public function basketJson()
    {
        return $this->hasOne(Shoppingcart::class, 'id', 'basket_id')->select('content')->get();
    }

    /**
     * @return array
     */
    public function basket()
    {
        return unserialize($this->basketJson()[0]->content);
    }
}
