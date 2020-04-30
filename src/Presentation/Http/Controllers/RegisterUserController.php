<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Validation\ValidationException;
use App\Presentation\Http\Response\CreatedResponse;
use App\Presentation\Http\Response\ValidationFailedResponse;
use App\UseCases\RegisterUser\RegisterUserRequest;
use App\UseCases\RegisterUser\RegisterUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    private $useCase;

    public function __construct(RegisterUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    final public function execute(Request $request): JsonResponse
    {
        $request = new RegisterUserRequest(
            $request->get('email'),
            $request->get('password'),
            $request->get('opt_in')
        );

        try {
            $response = $this->useCase->execute($request);
        } catch (ValidationException $exception) {
            return new ValidationFailedResponse($exception->getErrors());
        }

        return new CreatedResponse($response->toArray());
    }
}
