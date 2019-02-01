<?php

namespace App;

class Seller extends User
{
    use \Tightenco\Parental\HasParent;

    protected $guard_name = 'web';

    public function __construct()
    {
        $this->assignRole('seller');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function group_orders()
    {
        return $this->belongsToMany(GroupOrder::class);
    }
}
