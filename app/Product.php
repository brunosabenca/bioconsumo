<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
