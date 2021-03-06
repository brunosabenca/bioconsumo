<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Parental\HasChildren;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasChildren;
    use HasRoles;

    protected $childTypes = [
        'buyer' => Buyer::class,
        'seller' => Seller::class,
        'admin' => Admin::class,
    ];

    protected $guard_name = 'web';

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

    public function getAllPermissionsAttribute()
    {
        $all_permissions =  $this->getAllPermissions()->toArray();
        return array_column($all_permissions, 'name');
    }
}
