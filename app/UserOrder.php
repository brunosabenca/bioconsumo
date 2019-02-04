<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cknow\Money\Money;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id', 'group_order_id', 'billing_total', 'open', 'cancelled', 'delivered',
    ];

    protected $with = ['items'];

    protected $appends = array('is_active');

    protected $casts = [
        'open' => 'boolean',
        'cancelled' => 'boolean',
        'delivered' => 'boolean',
    ];

    public function path()
    {
        return "/user/orders/{$this->id}/";
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\GroupOrder', 'group_order_id', 'id');
    }
    
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    public function getIsActiveAttribute()
    {
        return $this->load('order')->order->is_active;
    }

    public function getPriceAttribute()
    {
        $total = '€0.00';
        foreach ($this->items as $item) {
            $item_price = money_parse_by_decimal($item->price, 'EUR');
            $total = money_parse($total)->add($item_price)->format();
        }

        return $total;
    }
}
