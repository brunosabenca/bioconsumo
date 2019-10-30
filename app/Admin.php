<?php

namespace App;

class Admin extends User
{
    use \Parental\HasParent;

    protected $guard_name = 'web';
}
