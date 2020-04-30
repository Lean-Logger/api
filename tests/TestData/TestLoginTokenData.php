<?php

use App\Domain\User\LoginTokenRepositoryInterface;
use App\Domain\User\User;

class TestLoginTokenData
{
    private $loginTokenRepository;

    public function __construct(LoginTokenRepositoryInterface $loginTokenRepository)
    {
        $this->loginTokenRepository = $loginTokenRepository;
    }

    public function createLoginTokenForUser(User $user, ?string $token = null): void
    {
        $this->loginTokenRepository->create($user->getId(), $token ?? 'testtoken');
    }
}