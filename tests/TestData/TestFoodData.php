<?php

use App\Domain\Food\Food;
use App\Domain\Food\FoodRepositoryInterface;
use App\Domain\User\User;

class TestFoodData
{
    public const FOOD_NAME = 'Intense Parmesano';

    private $foodRepository;

    public function __construct(FoodRepositoryInterface $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    public function createIntenseParmesano(User $user): Food
    {
        return $this->foodRepository->create(
            $user->getId(),
            self::FOOD_NAME
        );
    }
}