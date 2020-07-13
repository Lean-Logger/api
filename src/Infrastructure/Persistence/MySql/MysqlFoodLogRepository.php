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
            ->join('foods', 'foods.id', '=', 'food_logs.food_id')
            ->insertGetId($row)
        ;

        $row['id'] = $id;

        return $this->factory->createFromDatabaseRow($row);
    }

    public function findAllForUser(int $userId): array
    {
        $rows = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->select(\DB::raw('foods.id as food_id, foods.user_id as food_user_id, foods.name as food_name, foods.created_at as food_created_at, foods.updated_at as food_updated_at'))
            ->addSelect(\DB::raw('food_logs.*'))
            ->join('foods', 'foods.id', '=', 'food_logs.food_id')
            ->where('food_logs.user_id', '=', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
        ;

        $rows = json_decode(json_encode($rows->toArray()), true);

        return $this->factory->createMultipleFromDatabaseRows($rows);
    }
}