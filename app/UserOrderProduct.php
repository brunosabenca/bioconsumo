<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrderProduct extends Model
{
    protected $table = 'user_order_product';

    protected $fillable = ['user_order_id', 'product_id', 'quantity'];
}
