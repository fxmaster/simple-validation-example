<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    private string $username;
    private string $email;
    private string $password1;
    private string $password2;

    public function __construct(
        string $username,
        string $email,
        string $password1,
        string $password2
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password1 = $password1;
        $this->password2 = $password2;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword1(): string
    {
        return $this->password1;
    }

    public function getPassword2(): string
    {
        return $this->password2;
    }
}