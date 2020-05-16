<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\AddExerciseToLibrary\AddExerciseToLibraryUseCase;
use App\UseCases\AddExerciseToLibrary\AddExerciseToLibraryRequest;
use App\UseCases\GetExerciseLibrary\GetExerciseLibraryUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/exercises",
 *     operationId="getExerciseLibrary",
 *     summary="Fetch the authenticated users exercise library",
 *     tags={"Exercises"},
 *
 *     @OA\Response(response=200, description="Success", @OA\JsonContent(ref="#/components/schemas/GetExerciseLibraryResponse")),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class GetExerciseLibraryController extends Controller
{
    private $useCase;

    public function __construct(GetExerciseLibraryUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        try {
            $response = $this->useCase->execute($request->user()->getId());
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new SuccessResponse($response->toArray());
    }
}
