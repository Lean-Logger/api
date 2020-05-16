<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Domain\Exercise\ExerciseNotFoundException;
use App\Http\Controllers\Controller;
use App\Presentation\Http\Response\NotFoundResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\UseCases\DeleteExerciseFromLibrary\DeleteExerciseFromLibraryUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Delete(
 *     path="/api/exercises/{exerciseId}",
 *     operationId="deleteExercise",
 *     summary="Delete an existing exercise",
 *     tags={"Exercises"},
 *
 *     @OA\Parameter(in="path", name="exerciseId", @OA\Schema(type="string"), required=true),
 *
 *     @OA\Response(response=200, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
final class DeleteExerciseFromLibraryController extends Controller
{
    private $useCase;

    public function __construct(DeleteExerciseFromLibraryUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute($id): JsonResponse
    {
        try {
            $this->useCase->execute((int) $id);
        } catch (ExerciseNotFoundException $exception) {
            return new NotFoundResponse('Exercise could not be found');
        }

        return new SuccessResponse();
    }
}
