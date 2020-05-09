<?php

use App\Domain\Exercise\ExerciseRepositoryInterface;

class TestExerciseData
{
    public const EXERCISE_NAME = 'Alternating Dumbbell Bicep Curls';

    private $exerciseRepository;

    public function __construct(ExerciseRepositoryInterface $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }
}