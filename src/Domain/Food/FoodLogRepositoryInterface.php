<?php

declare(strict_types=1);

namespace App\Domain\Food;

interface FoodLogRepositoryInterface
{
    public function create(int $userId, int $foodId, ?\DateTime $dateTime): FoodLog;

    public function findAllForUser(int $userId): array;
}