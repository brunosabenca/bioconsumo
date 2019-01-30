<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tightenco\Parental\HasChildren;

class User extends Authenticatable
{
    use Notifiable;
    use HasChildren;
    use \Tightenco\Parental\HasChildren;

    protected $childTypes = [
        'admin' => Admin::class,
        'guest' => Guest::class,
        'seller' => Seller::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany('App\UserOrder');
    }
}
