<?php

declare(strict_types=1);

namespace App\UseCases\LogFoodConsumption;

use App\Domain\Food\FoodLogRepositoryInterface;
use App\Domain\Food\FoodRepositoryInterface;
use App\Infrastructure\Validation\LogFoodConsumptionValidation;

final class LogFoodConsumptionUseCase
{
    private $foodLogRepository;

    private $foodRepository;

    private $validation;

    public function __construct(FoodLogRepositoryInterface $foodLogRepository, FoodRepositoryInterface $foodRepository, LogFoodConsumptionValidation $validation)
    {
        $this->foodLogRepository = $foodLogRepository;
        $this->foodRepository = $foodRepository;
        $this->validation = $validation;
    }

    final public function execute(LogFoodConsumptionRequest $request): LogFoodConsumptionResponse
    {
        $this->validation->validate($request->toArray());

        $food = $this->foodRepository->findByName($request->getName());

        if (null === $food) {
            $food = $this->foodRepository->create($request->getUserId(), $request->getName());
        }

        $dateTime = $request->getDateTime() ? new \DateTime($request->getDateTime()) : null;
        $foodLog = $this->foodLogRepository->create($request->getUserId(), $food->getId(), $dateTime);

        return new LogFoodConsumptionResponse($foodLog);
    }
}