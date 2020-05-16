<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\Exercise\Exercise;
use App\Domain\Exercise\ExerciseFactory;
use App\Domain\Exercise\ExerciseRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

final class MysqlExerciseRepository extends MySqlAbstractRepository implements ExerciseRepositoryInterface
{
    private const TABLE_NAME = 'exercises';

    private $factory;

    public function __construct(DatabaseManager $queryBuilder, ExerciseFactory $factory)
    {
        parent::__construct($queryBuilder);

        $this->factory = $factory;
    }

    public function create(int $userId, string $name, ?string $description, string $type): Exercise
    {
        $now = (new Carbon())->format('Y-m-d H:i:s');

        $row = [
            'user_id' => $userId,
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $id = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insertGetId($row)
        ;

        $row['id'] = $id;

        return $this->factory->createFromDatabaseRow($row);
    }

    public function update(Exercise $exercise, string $name, ?string $description, string $type): void
    {
        $row = [
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'updated_at' => (new Carbon())->format('Y-m-d H:i:s'),
        ];

        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('id', '=', $exercise->getId())
            ->update($row)
        ;
    }

    public function findOneById(int $id): ?Exercise
    {
        $row = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->find($id)
        ;

        return $row ? $this->factory->createFromDatabaseRow((array) $row) : null;
    }

    public function findAllByUserId(int $userId): array
    {
        $rows = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('user_id', '=', $userId)
            ->get()
        ;

        $results = json_decode(json_encode($rows->toArray()), true);

        return $this->factory->createMultipleFromDatabaseRows($results);
    }


    public function delete(Exercise $exercise): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->delete($exercise->getId())
        ;
    }
}