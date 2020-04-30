<?php

declare(strict_types=1);

namespace App\UseCases\LogoutUser;

use App\Domain\User\LoginTokenRepositoryInterface;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Validation\LogoutUserValidation;

final class LogoutUserUseCase
{
    private $userRepository;

    private $loginTokenRepository;

    private $validation;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LoginTokenRepositoryInterface $loginTokenRepository,
        LogoutUserValidation $validation
    ){
        $this->userRepository = $userRepository;
        $this->loginTokenRepository = $loginTokenRepository;
        $this->validation = $validation;
    }

    final public function execute(LogoutUserRequest $request): void
    {
        $this->validation->validate($request->toArray());

        $user = $this->userRepository->findOneById($request->getUserId());

        if (!$user) {
            throw new UserNotFoundException('User not found');
        }

        $this->loginTokenRepository->deleteAllForUser($user->getId());
    }
}