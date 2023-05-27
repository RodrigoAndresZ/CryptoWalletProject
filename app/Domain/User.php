<?php

namespace App\Domain;

class User
{
    private int $user_id;


    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getIdUser(): int
    {
        return $this->user_id;
    }
}
