<?php

declare(strict_types=1);

namespace App\Domain\Exercise;

interface ExerciseRepositoryInterface
{
    public function create(int $userId, string $name, ?string $description, string $type): Exercise;
}