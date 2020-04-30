<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\NotFoundResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\LoginUser\LoginUserRequest;
use App\UseCases\LoginUser\LoginUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/login",
 *     operationId="login",
 *     summary="Exchange a valid username/password combination for a login token",
 *     tags={"Authentication"},
 *
 *     @OA\RequestBody(
 *      required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(ref="#/components/schemas/LoginUserRequest")
 *          )
 *     ),
 *
 *     @OA\Response(response=201, description="Success", @OA\JsonContent(ref="#/components/schemas/LoginUserResponse")),
 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
 *     @OA\Response(response=422, ref="#/components/responses/BadRequest"),
 *     @OA\Response(response=500, ref="#/components/responses/ServerError")
 * )
 */
class LoginUserController extends Controller
{
    private $useCase;

    public function __construct(LoginUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new LoginUserRequest(
            $request->get('email'),
            $request->get('password')
        );

        try {
            $response = $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        } catch (UserNotFoundException $exception) {
            return new NotFoundResponse($exception->getMessage());
        }

        return new CreatedResponse($response->toArray());
    }
}
