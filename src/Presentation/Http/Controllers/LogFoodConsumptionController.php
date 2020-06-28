<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\LogFoodConsumption\LogFoodConsumptionRequest;
use App\UseCases\LogFoodConsumption\LogFoodConsumptionUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/foodlog",
 *     operationId="logFoodConsumption",
 *     summary="Log food consumption",
 *     tags={"Exercises"},
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/LogFoodConsumptionRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=201, description="Success", @OA\JsonContent(ref="#/components/schemas/LogFoodConsumptionResponse")),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class LogFoodConsumptionController extends Controller
{
    private $useCase;

    public function __construct(LogFoodConsumptionUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new LogFoodConsumptionRequest(
            $request->user()->getId(),
            $request->get('name'),
            $request->get('date_time')
        );

        try {
            $response = $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new CreatedResponse($response->toArray());
    }
}
