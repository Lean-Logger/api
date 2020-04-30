<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\User\LoginTokenRepositoryInterface;

final class MySqlLoginTokenRepository extends MySqlAbstractRepository implements LoginTokenRepositoryInterface
{
    private const TABLE_NAME = 'login_tokens';

    public function create(int $userId, string $token): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insert([
                'user_id' => $userId,
                'token' => $token,
            ])
        ;
    }

    public function deleteAllForUser(int $userId): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('user_id', '=', $userId)
            ->delete()
        ;
    }
}