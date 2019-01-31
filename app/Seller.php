<?php

namespace App;

class Seller extends User
{
    use \Tightenco\Parental\HasParent;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(GroupOrder::class);
    }
}
