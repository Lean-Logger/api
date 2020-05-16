<?php

use App\Domain\Exercise\Exercise;
use App\Domain\Exercise\ExerciseRepositoryInterface;
use App\Domain\User\User;

class TestExerciseData
{
    public const EXERCISE_NAME = 'Alternating Dumbbell Bicep Curls';

    public const TYPE_WEIGHTED_REPS = 'weighted_reps';

    private $exerciseRepository;

    public function __construct(ExerciseRepositoryInterface $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function createBicepCurlExerciseForUser(User $user): Exercise
    {
        return $this->exerciseRepository->create(
            $user->getId(),
            self::EXERCISE_NAME,
            '',
            self::TYPE_WEIGHTED_REPS
        );
    }
}