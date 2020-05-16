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
 *          @OA\Property(property="id", type="number", format="integer"),
 *          @OA\Property(property="user_id", type="number", format="integer"),
 *          @OA\Property(property="name", type="string", example="Bicep Curl Machine"),
 *          @OA\Property(property="description", type="string", example="The machine near the AC unit"),
 *          @OA\Property(property="type", type="string", enum={"weighted_reps", "non_weighted_reps", "duration"}),
 *          @OA\Property(property="created_at", type="string", format="date-time"),
 *          @OA\Property(property="updated_at", type="string", format="date-time")
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