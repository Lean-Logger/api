<?php

declare(strict_types=1);

namespace App\Domain\User;

interface LoginTokenRepositoryInterface
{
    public function create(int $userId, string $token): void;

    public function deleteAllForUser(int $userId): void;

    public function findOneByToken(string $token): ?LoginToken;
}