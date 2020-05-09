<?php

declare(strict_types=1);

namespace App\UseCases\AddExerciseToLibrary;

use App\Domain\Exercise\Exercise;

/**
 * @OA\Schema(
 *     schema="AddExerciseToLibraryResponse",
 *     title="Add exercise to library response",
 *     type="object",
 *     properties={
 *          @OA\Property(property="login_token", type="string")
 *     }
 * )
 */
final class AddExerciseToLibraryResponse
{
    private $exercise;

    public function __construct(Exercise $exercise)
    {
        $this->exercise = $exercise;
    }

    public function toArray(): array
    {
        return $this->exercise->toArray();
    }
}