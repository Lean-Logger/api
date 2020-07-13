<?php

declare(strict_types=1);

namespace App\UseCases\GetFoodLogs;

use App\Domain\Food\FoodLogRepositoryInterface;
use App\Domain\Food\FoodRepositoryInterface;
use App\Infrastructure\Validation\GetFoodLogsValidation;

final class GetFoodLogsUseCase
{
    private $foodLogRepository;

    private $foodRepository;

    private $validation;

    public function __construct(FoodLogRepositoryInterface $foodLogRepository, FoodRepositoryInterface $foodRepository, GetFoodLogsValidation $validation)
    {
        $this->foodLogRepository = $foodLogRepository;
        $this->foodRepository = $foodRepository;
        $this->validation = $validation;
    }

    final public function execute(GetFoodLogsRequest $request): GetFoodLogsResponse
    {
        $this->validation->validate($request->toArray());

        $foodLogs = $this->foodLogRepository->findAllForUser($request->getUserId());

        return new GetFoodLogsResponse($foodLogs);
    }
}