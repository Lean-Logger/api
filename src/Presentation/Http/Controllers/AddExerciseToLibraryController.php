<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\AddExerciseToLibrary\AddExerciseToLibraryUseCase;
use App\UseCases\AddExerciseToLibrary\AddExerciseToLibraryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/exercises",
 *     operationId="addExerciseToLibrary",
 *     summary="Add a new exercise to the users library",
 *     tags={"Exercises"},
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/AddExerciseToLibraryRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=201, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class AddExerciseToLibraryController extends Controller
{
    private $useCase;

    public function __construct(AddExerciseToLibraryUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new AddExerciseToLibraryRequest(
            $request->get('user_id'),
            $request->get('name'),
            $request->get('description'),
            $request->get('type')
        );

        try {
            $response = $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new CreatedResponse($response->toArray());
    }
}
