<?php

declare(strict_types=1);

namespace App\UseCases\EditExercise;

use App\Domain\Exercise\ExerciseNotFoundException;
use App\Domain\Exercise\ExerciseRepositoryInterface;
use App\Infrastructure\Validation\EditExerciseValidation;

final class EditExerciseUseCase
{
    private $repository;

    private $validation;

    public function __construct(ExerciseRepositoryInterface $repository, EditExerciseValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    final public function execute(EditExerciseRequest $request): void
    {
        $this->validation->validate($request->toArray());

        $exercise = $this->repository->findOneById($request->getExerciseId());

        if (!$exercise) {
            throw new ExerciseNotFoundException();
        }

        $this->repository->update(
            $exercise,
            $request->getName(),
            $request->getDescription(),
            $request->getType()
        );
    }
}