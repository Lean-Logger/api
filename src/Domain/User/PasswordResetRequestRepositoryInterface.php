<?php

declare(strict_types=1);

namespace App\Domain\User;

interface PasswordResetRequestRepositoryInterface
{
    public function create(string $email, int $code, \DateTimeInterface $expiresAt): void;

    public function hasUnexpiredOneForEmailAndCode(string $email, int $code): bool;

    public function deleteByEmailAndCode(string $email, int $code): void;
}