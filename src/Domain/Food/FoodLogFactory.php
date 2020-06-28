<?php

declare(strict_types=1);

namespace App\Domain\Food;

final class FoodLogFactory {

    public function createFromDatabaseRow(array $row): FoodLog
    {
        return (new FoodLog())
            ->setId((int) $row['id'])
            ->setUserId((int) $row['user_id'])
            ->setFoodId((int) $row['food_id'])
            ->setDateTime(empty($row['date_time']) ? null : new \DateTime($row['date_time']))
            ->setCreatedAt(new \DateTime($row['created_at']))
            ->setUpdatedAt(new \DateTime($row['updated_at']))
            ;
    }

    /**
     * @return FoodLog[]
     */
    public function createMultipleFromDatabaseRows(array $data): array
    {
        return array_map([$this, 'createFromDatabaseRow'], $data);
    }
}