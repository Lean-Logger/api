<?php

use App\Domain\Food\Food;
use App\Domain\Food\FoodLog;
use App\Domain\Food\FoodLogRepositoryInterface;
use App\Domain\User\User;

class TestFoodLogData
{
    private $foodLogRepository;

    public function __construct(FoodLogRepositoryInterface $foodLogRepository)
    {
        $this->foodLogRepository = $foodLogRepository;
    }

    public function logFoodForUser(Food $food, User $user, DateTimeInterface $dateTime): FoodLog
    {
        return $this->foodLogRepository->create($user->getId(), $food->getId(), $dateTime);
    }
}