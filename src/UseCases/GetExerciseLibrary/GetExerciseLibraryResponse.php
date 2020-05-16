<?php

declare(strict_types=1);

namespace App\UseCases\GetExerciseLibrary;

use App\Domain\Exercise\Exercise;

/**
 * @OA\Schema(
 *     schema="GetExerciseLibraryResponse",
 *     title="Get Exercise Library Response",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/AddExerciseToLibraryResponse")
 * )
 */
final class GetExerciseLibraryResponse
{
    private $exercises;

    public function __construct(array $exercises)
    {
        $this->exercises = $exercises;
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(function(Exercise $exercise) {
                return $exercise->toArray();
            }, $this->exercises),
        ];
    }
}