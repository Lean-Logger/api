<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\User\User;
use App\Domain\User\UserFactory;
use App\Domain\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

final class MySqlUserRepository extends MySqlAbstractRepository implements UserRepositoryInterface
{
    private const TABLE_NAME = 'users';

    private $factory;

    public function __construct(DatabaseManager $queryBuilder, UserFactory $factory)
    {
        parent::__construct($queryBuilder);

        $this->factory = $factory;
    }

    public function register(string $email, string $password, bool $optIn): User
    {
        $row = [
            'email' => $email,
            'password' => $password,
            'opt_in' => $optIn,
            'created_at' => (new Carbon())->format('Y-m-d H:i:s'),
        ];

        $id = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insertGetId($row)
        ;

        $row['id'] = $id;

        return $this->factory->createFromDatabaseRow($row);
    }

    public function findOneByEmailAddress(string $email): ?User
    {
        $user = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('email', '=', $email)
            ->first()
        ;

        if (!$user) {
            return null;
        }

        return $this->factory->createFromDatabaseRow((array) $user);
    }

    public function findOneById(int $id): ?User
    {
        $user = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('id', '=', $id)
            ->first()
        ;

        if (!$user) {
            return null;
        }

        return $this->factory->createFromDatabaseRow((array) $user);
    }

    public function updatePassword(User $user, string $password): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('id', '=', $user->getId())
            ->update([
                'password' => $password,
            ]);
    }
}