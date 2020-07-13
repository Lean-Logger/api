<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\GetFoodLogs\GetFoodLogsRequest;
use App\UseCases\GetFoodLogs\GetFoodLogsUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/foodlog",
 *     operationId="getFoodLogs",
 *     summary="Get food logs",
 *     tags={"Food Log"},
 *
 *     @OA\Parameter(in="query", name="date", @OA\Schema(type="string"), required=true),
 *
 *     @OA\Response(response=201, description="Success", @OA\JsonContent(ref="#/components/schemas/GetFoodLogsResponse")),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class GetFoodLogsController extends Controller
{
    private $useCase;

    public function __construct(GetFoodLogsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new GetFoodLogsRequest(
            $request->user()->getId(),
            $request->get('date')
        );

        try {
            $response = $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new SuccessResponse($response->toArray());
    }
}
