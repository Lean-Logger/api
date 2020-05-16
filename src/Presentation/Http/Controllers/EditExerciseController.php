<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Domain\Exercise\ExerciseNotFoundException;
use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\NotFoundResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\EditExercise\EditExerciseRequest;
use App\UseCases\EditExercise\EditExerciseUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Put(
 *     path="/api/exercises/{exerciseId}",
 *     operationId="editExercise",
 *     summary="Exit an existing exercise",
 *     tags={"Exercises"},
 *
 *     @OA\Parameter(in="path", name="exerciseId", @OA\Schema(type="string"), required=true),
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/EditExerciseRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=200, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
final class EditExerciseController extends Controller
{
    private $useCase;

    public function __construct(EditExerciseUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request, $id): JsonResponse
    {
        $request = new EditExerciseRequest(
            (int) $id,
            $request->get('user_id'),
            $request->get('name'),
            $request->get('description'),
            $request->get('type')
        );

        try {
            $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        } catch (ExerciseNotFoundException $exception) {
            return new NotFoundResponse('Exercise could not be found');
        }

        return new SuccessResponse();
    }
}
