<?php

declare(strict_types=1);

namespace App\UseCases\DeleteExerciseFromLibrary;

use App\Domain\Exercise\ExerciseNotFoundException;
use App\Domain\Exercise\ExerciseRepositoryInterface;

final class DeleteExerciseFromLibraryUseCase
{
    private $repository;

    public function __construct(ExerciseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    final public function execute(int $exerciseId): void
    {
        $exercise = $this->repository->findOneById($exerciseId);

        if (!$exercise) {
            throw new ExerciseNotFoundException();
        }

        $this->repository->delete($exercise);
    }
}