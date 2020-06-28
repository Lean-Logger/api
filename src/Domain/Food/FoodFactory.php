<?php

declare(strict_types=1);

namespace App\Domain\Food;

final class FoodFactory {

    public function createFromDatabaseRow(array $row): Food
    {
        return (new Food())
            ->setId((int) $row['id'])
            ->setUserId($row['user_id'])
            ->setName($row['name'])
            ->setCreatedAt(new \DateTime($row['created_at']))
            ->setUpdatedAt(new \DateTime($row['updated_at']))
            ;
    }

    /**
     * @return Food[]
     */
    public function createMultipleFromDatabaseRows(array $data): array
    {
        return array_map([$this, 'createFromDatabaseRow'], $data);
    }
}