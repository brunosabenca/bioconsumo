<?php

namespace App;

class Admin extends User
{
    use \Tightenco\Parental\HasParent;

    protected $guard_name = 'web';
}
