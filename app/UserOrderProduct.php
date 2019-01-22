<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'user_order_product';

    protected $fillable = ['order_id', 'product_id', 'quantity'];
}
