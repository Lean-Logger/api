<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\User\PasswordResetRequestRepositoryInterface;
use Carbon\Carbon;

final class MySqlPasswordRequestRepositoryRepository extends MySqlAbstractRepository implements PasswordResetRequestRepositoryInterface
{
    private const TABLE_NAME = 'password_reset_requests';

    public function create(string $email, int $code, \DateTimeInterface $expiresAt): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insert([
                'email' => $email,
                'code' => $code,
                'expires_at' => $expiresAt,
                'created_at' => (new Carbon())->format('Y-m-d H:i:s'),
            ])
        ;
    }

    public function hasUnexpiredOneForEmailAndCode(string $email, int $code): bool
    {
        $result = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('email', '=', $email)
            ->where('code', '=', $code)
            ->where('expires_at', '>', new Carbon('now'))
            ->first()
        ;

        return (null !== $result);
    }

    public function deleteByEmailAndCode(string $email, int $code): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('email', '=', $email)
            ->where('code', '=', $code)
            ->delete()
        ;
    }
}