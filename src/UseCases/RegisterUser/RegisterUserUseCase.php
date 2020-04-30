<?php

declare(strict_types=1);

namespace App\UseCases\RegisterUser;

use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Validation\RegisterUserValidation;
use Illuminate\Support\Facades\Hash;

final class RegisterUserUseCase
{
    private $repository;

    private $validation;

    public function __construct(UserRepositoryInterface $repository, RegisterUserValidation $validation)
    {
        $this->repository = $repository;
        $this->validation = $validation;
    }

    final public function execute(RegisterUserRequest $request): RegisterUserResponse
    {
        $this->validation->validate($request->toArray());

        $user = $this->repository->register(
            $request->getEmail(),
            Hash::make($request->getPassword()),
            (bool) $request->getOptIn()
        );

        return new RegisterUserResponse($user);
    }
}