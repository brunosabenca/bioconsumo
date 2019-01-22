<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id', 'billing_total', 'delivered',
    ];

    protected $casts = [
        'delivered' => 'boolean',
    ];

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
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }
}
