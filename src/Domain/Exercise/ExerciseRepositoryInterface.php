<?php

declare(strict_types=1);

namespace App\Domain\Exercise;

interface ExerciseRepositoryInterface
{
    public function create(int $userId, string $name, ?string $description, string $type): Exercise;

    public function update(Exercise $exercise, string $name, ?string $description, string $type): void;

    public function findOneById(int $id): ?Exercise;
}