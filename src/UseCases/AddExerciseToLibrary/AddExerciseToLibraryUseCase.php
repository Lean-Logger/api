<?php

declare(strict_types=1);

namespace App\UseCases\AddExerciseToLibrary;

use App\Domain\Exercise\ExerciseRepositoryInterface;
use App\Infrastructure\Validation\AddExerciseToLibraryValidation;

final class AddExerciseToLibraryUseCase
{
    private $repository;

    private $validation;

    public function __construct(ExerciseRepositoryInterface $repository, AddExerciseToLibraryValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    final public function execute(AddExerciseToLibraryRequest $request): AddExerciseToLibraryResponse
    {
        $this->validation->validate($request->toArray());

        $exercise = $this->repository->create(
            $request->getUserId(),
            $request->getName(),
            $request->getDescription(),
            $request->getType()
        );

        return new AddExerciseToLibraryResponse($exercise);
    }
}