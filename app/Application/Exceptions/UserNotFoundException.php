<?php

namespace App\Application\Exceptions;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("user not found");
    }
}
