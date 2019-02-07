<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cknow\Money\Money;

class Product extends Model
{
    use SoftDeletes;

    protected $attributes = [
        'stock' => 0,
        'stock_unit_type' => 'Kg',
    ];

     protected $casts = [
        'price' => 'string',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

   /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get a string path for the product listing page.
     *
     * @return string
     */
    public function path()
    {
        return "/products/{$this->id}";
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id', 'id');
    }
}
