<?php

declare(strict_types=1);

namespace App\UseCases\LoginUser;

use App\Domain\User\LoginTokenRepositoryInterface;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\TokenGenerator;
use App\Infrastructure\Validation\LoginUserValidation;
use Illuminate\Support\Facades\Hash;

final class LoginUserUseCase
{
    private $userRepository;

    private $loginTokenRepository;

    private $validation;

    private $tokenGenerator;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LoginTokenRepositoryInterface $loginTokenRepository,
        LoginUserValidation $validation,
        TokenGenerator $tokenGenerator
    ){
        $this->userRepository = $userRepository;
        $this->loginTokenRepository = $loginTokenRepository;
        $this->validation = $validation;
        $this->tokenGenerator = $tokenGenerator;
    }

    final public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $this->validation->validate($request->toArray());

        $user = $this->userRepository->findOneByEmailAddress($request->getEmail());

        if (!$user) {
            throw new UserNotFoundException('User not found');
        }

        if (false === Hash::check($request->getPassword(), $user->getPassword())) {
            throw new UserNotFoundException('User not found');
        }

        $loginToken = $this->tokenGenerator->generate(32);

        $this->loginTokenRepository->create($user->getId(), $loginToken);

        return new LoginUserResponse($loginToken);
    }
}