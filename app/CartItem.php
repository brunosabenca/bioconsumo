<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';

    protected $fillable = ['user_order_id', 'product_id', 'quantity'];

    protected $with = ['product'];

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo('App\UserOrder', 'user_order_id', 'id');
    }

    public function incrementQty(int $qty = 1)
    {
        $this->quantity = $this->quantity + $qty;
        $this->save();
    }
    public function decrementQty(int $qty = 1)
    {
        $this->quantity = $this->quantity - $qty ;
        $this->save();
    }
}
