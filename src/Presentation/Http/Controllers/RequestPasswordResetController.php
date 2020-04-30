<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\RequestPasswordReset\RequestPasswordResetRequest;
use App\UseCases\RequestPasswordReset\RequestPasswordResetUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/request-password-reset",
 *     operationId="request-password-reset",
 *     summary="Trigger a password reset email to be sent",
 *     tags={"Authentication"},
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/RequestPasswordResetRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=201, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class RequestPasswordResetController extends Controller
{
    private $useCase;

    public function __construct(RequestPasswordResetUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new RequestPasswordResetRequest(
            $request->get('email')
        );

        try {
            $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new CreatedResponse();
    }
}