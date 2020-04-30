<?php

declare(strict_types=1);

namespace App\UseCases\RegisterUser;

final class RegisterUserRequest
{
    private $email;

    private $password;

    private $optIn;

    public function __construct($email, $password, $optIn)
    {
        $this->email = $email;
        $this->password = $password;
        $this->optIn = $optIn;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getOptIn()
    {
        return $this->optIn;
    }

    public function toArray()
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'opt_in' => $this->getOptIn(),
        ];
    }
}