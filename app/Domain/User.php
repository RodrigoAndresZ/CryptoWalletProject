<?php

namespace App\Domain;

class User
{
    private int $user_id
    
    private string $email;

    public function __construct(int $user_id, string $email)
    {
        $this->user_id = $user_id;
        $this->email = $email;
    }

    public function getIdUser(): int
    {
        return $this->user_id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
