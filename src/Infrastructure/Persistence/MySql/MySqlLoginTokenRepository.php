<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\User\LoginToken;
use App\Domain\User\LoginTokenFactory;
use App\Domain\User\LoginTokenRepositoryInterface;
use Illuminate\Database\DatabaseManager;

final class MySqlLoginTokenRepository extends MySqlAbstractRepository implements LoginTokenRepositoryInterface
{
    private const TABLE_NAME = 'login_tokens';

    private $factory;

    public function __construct(DatabaseManager $queryBuilder, LoginTokenFactory $factory)
    {
        parent::__construct($queryBuilder);

        $this->factory = $factory;
    }


    public function create(int $userId, string $token): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insert([
                'user_id' => $userId,
                'token' => $token,
                'created_at' => new \Carbon\Carbon('now'),
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

    public function findOneByToken(string $token): ?LoginToken
    {
        $row = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('token', '=', $token)
            ->first()
        ;

        return $row ? $this->factory->createFromDatabaseRow((array) $row) : null;
    }


}