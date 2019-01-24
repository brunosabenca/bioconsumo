<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id', 'group_order_id', 'billing_total', 'open', 'cancelled', 'delivered',
    ];

    protected $with = ['items'];

    protected $casts = [
        'open' => 'boolean',
        'cancelled' => 'boolean',
        'delivered' => 'boolean',
    ];

    public function path()
    {
        return "/user/orders/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\GroupOrder');
    }
    
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }
}
