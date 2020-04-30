<?php

declare(strict_types=1);

namespace App\UseCases\RegisterUser;

use App\Domain\User\User;

final class RegisterUserResponse
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return $this->user->toArray();
    }
}