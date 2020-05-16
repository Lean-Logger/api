<?php

declare(strict_types=1);

namespace App\UseCases\GetExerciseLibrary;

use App\Domain\Exercise\ExerciseRepositoryInterface;

final class GetExerciseLibraryUseCase
{
    private $repository;

    public function __construct(ExerciseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    final public function execute(int $userId): GetExerciseLibraryResponse
    {
        $exercises = $this->repository->findAllByUserId($userId);

        return new GetExerciseLibraryResponse($exercises);
    }
}