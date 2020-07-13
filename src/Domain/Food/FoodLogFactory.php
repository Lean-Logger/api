<?php

declare(strict_types=1);

namespace App\Domain\Food;

final class FoodLogFactory
{
    private $foodFactory;

    public function __construct(FoodFactory $foodFactory)
    {
        $this->foodFactory = $foodFactory;
    }

    public function createFromDatabaseRow(array $row): FoodLog
    {
        $foodLog = (new FoodLog())
            ->setId((int) $row['id'])
            ->setUserId((int) $row['user_id'])
            ->setFoodId((int) $row['food_id'])
            ->setDateTime(empty($row['date_time']) ? null : new \DateTime($row['date_time']))
            ->setCreatedAt(new \DateTime($row['created_at']))
            ->setUpdatedAt(new \DateTime($row['updated_at']))
            ;

        if (isset($row['food_user_id'])) {
            $foodLog->setFood($this->foodFactory->createFromDatabaseRow([
                'id' => $row['food_id'],
                'user_id' => $row['food_user_id'],
                'name' => $row['food_name'],
                'created_at' => $row['food_created_at'],
                'updated_at' => $row['food_updated_at'],
            ]));
        }

        return $foodLog;
    }

    /**
     * @return FoodLog[]
     */
    public function createMultipleFromDatabaseRows(array $data): array
    {
        return array_map([$this, 'createFromDatabaseRow'], $data);
    }
}