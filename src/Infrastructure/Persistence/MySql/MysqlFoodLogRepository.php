<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MySql;

use App\Domain\Food\FoodLog;
use App\Domain\Food\FoodLogFactory;
use App\Domain\Food\FoodLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;

final class MysqlFoodLogRepository extends MySqlAbstractRepository implements FoodLogRepositoryInterface
{
    private const TABLE_NAME = 'food_logs';

    private $factory;

    public function __construct(DatabaseManager $queryBuilder, FoodLogFactory $factory)
    {
        parent::__construct($queryBuilder);

        $this->factory = $factory;
    }

    public function create(int $userId, int $foodId, ?\DateTime $dateTime): FoodLog
    {
        $now = (new Carbon())->format('Y-m-d H:i:s');

        $row = [
            'user_id' => $userId,
            'food_id' => $foodId,
            'date_time' => $dateTime ? $dateTime->format('Y-m-d H:i:s') : null,
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