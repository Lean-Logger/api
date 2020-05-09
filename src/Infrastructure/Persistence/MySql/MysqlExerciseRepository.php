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

}