<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\NotFoundResponse;
use App\Presentation\Http\Response\SuccessResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\LogoutUser\LogoutUserRequest;
use App\UseCases\LogoutUser\LogoutUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/logout",
 *     operationId="logout",
 *     summary="Invalidate all login tokens for a user",
 *     tags={"Authentication"},
 *
 *     @OA\Response(response=200, description="Success"),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class LogoutUserController extends Controller
{
    private $useCase;

    public function __construct(LogoutUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new LogoutUserRequest(
            $request->user()->getId()
        );

        try {
            $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        } catch (UserNotFoundException $exception) {
            return new NotFoundResponse($exception->getMessage());
        }

        return new SuccessResponse();
    }
}
