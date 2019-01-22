<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupOrder extends Model
{
    protected $guarded = [];
    /**
     * Get a string path for the group order page.
     *
     * @return string
     */
    public function path()
    {
        return "/orders/{$this->id}";
    }

    public function name()
    {
        return "Order #" . $this->id . ":" . $this->open_date . " to " . $this->close_date;
    }

    public function orders()
    {
        return $this->hasMany('App\UserOrder');
    }
}
