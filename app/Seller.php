<?php

namespace App;

class Seller extends User
{
    use \Parental\HasParent;

    protected $guard_name = 'web';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function group_orders()
    {
        return $this->belongsToMany(GroupOrder::class, 'group_order_seller');
    }
}
