<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function register(string $email, string $password, bool $optIn): User;

    public function findOneByEmailAddress(string $email): ?User;

    public function findOneById(int $id): ?User;

    public function updatePassword(User $user, string $password): void;
}