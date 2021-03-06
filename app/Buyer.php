<?php

namespace App;

class Buyer extends User
{
    use \Parental\HasParent;

    protected $guard_name = 'web';

    public function group_orders()
    {
        return $this->belongsToMany(GroupOrder::class);
    }
}
