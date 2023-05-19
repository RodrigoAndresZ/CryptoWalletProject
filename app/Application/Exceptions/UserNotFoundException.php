<?php

namespace App\Application\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("user not found");
    }
}
