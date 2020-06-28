<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\Exercise\Exercise;
use App\Domain\Exercise\ExerciseFactory;
use App\Domain\Exercise\ExerciseRepositoryInterface;
use App\Domain\Food\Food;
use App\Domain\Food\FoodFactory;
use App\Domain\Food\FoodRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

final class MysqlFoodRepository extends MySqlAbstractRepository implements FoodRepositoryInterface
{
    private const TABLE_NAME = 'foods';

    private $factory;

    public function __construct(DatabaseManager $queryBuilder, FoodFactory $factory)
    {
        parent::__construct($queryBuilder);

        $this->factory = $factory;
    }

    public function create(int $userId, string $name): Food
    {
        $now = (new Carbon())->format('Y-m-d H:i:s');

        $row = [
            'user_id' => $userId,
            'name' => $name,
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

    public function findByName(string $name): ?Food
    {
        $row = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->where('name', '=', $name)
            ->first()
        ;

        return $row ? $this->factory->createFromDatabaseRow((array) $row) : null;
    }
}