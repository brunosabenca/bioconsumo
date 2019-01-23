<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id', 'group_order_id', 'billing_total', 'delivered',
    ];

    protected $with = ['products'];

    protected $casts = [
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
    
    public function products()
    {
        return $this->hasMany('App\UserOrderProduct');
    }
}
