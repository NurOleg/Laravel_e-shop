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
        'basket' => 'Корзина'
    ];
    //

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'delivery_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function basket()
    {
        return $this->hasOne(Shoppingcart::class);
    }
}
