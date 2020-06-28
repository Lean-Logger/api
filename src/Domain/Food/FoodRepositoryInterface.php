<?php

declare(strict_types=1);

namespace App\Domain\Food;

interface FoodRepositoryInterface
{
    public function create(int $userId, string $name): Food;

    public function findByName(string $name): ?Food;
}