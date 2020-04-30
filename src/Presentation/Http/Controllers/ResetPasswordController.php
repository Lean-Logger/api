<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers;

use App\Domain\User\PasswordResetRequestNotFoundException;
use App\Domain\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\NotFoundResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\ResetPassword\ResetPasswordRequest;
use App\UseCases\ResetPassword\ResetPasswordUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/reset-password",
 *     operationId="reset-password",
 *     summary="Reset a Users password",
 *     tags={"Authentication"},
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/ResetPasswordRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=201, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class ResetPasswordController extends Controller
{
    private $useCase;

    public function __construct(ResetPasswordUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new ResetPasswordRequest(
            $request->get('email'),
            $request->get('code'),
            $request->get('password')
        );

        try {
            $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        } catch (UserNotFoundException | PasswordResetRequestNotFoundException $exception) {
            return new NotFoundResponse("Reset password code not found");
        }

        return new SuccessResponse();
    }
}