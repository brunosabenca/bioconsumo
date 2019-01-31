<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GroupOrder extends Model
{
    protected $appends = array('is_active');

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
        return "Group Order #" . $this->id;
    }

    public function orders()
    {
        return $this->hasMany('App\UserOrder');
    }

    public function sellers()
    {
        return $this->belongsToMany('App\Seller');
    }

    protected function isActive()
    {
        $date = Carbon::now();

        $overlapsCount = GroupOrder::where('id', $this->id)->where('cancelled', false)->where(function ($query) use ($date) {
            $query->where(function ($query) use ($date) {
                    $query->where('open_date', '<=', $date)
                    ->where('close_date', '>=', $date);
            })->orWhere(function ($query) use ($date) {
                    $query->where('open_date', '<=', $date)
                        ->where('close_date', '>=', $date);
            });
        })->count();

        if ($overlapsCount > 0) {
            return true;
        } else {
            return false;
        };
    }

    public function getIsActiveAttribute()
    {
        return $this->isActive();
    }
}
