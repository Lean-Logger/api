<?php

declare(strict_types=1);

namespace App\UseCases\ResetPassword;

use App\Domain\User\PasswordResetRequestNotFoundException;
use App\Domain\User\PasswordResetRequestRepositoryInterface;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Validation\ResetPasswordValidation;
use Illuminate\Support\Facades\Hash;

final class ResetPasswordUseCase
{
    private $userRepository;

    private $validation;

    private $passwordResetRequestRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordResetRequestRepositoryInterface $passwordResetRequestRepository,
        ResetPasswordValidation $validation
    ){
        $this->userRepository = $userRepository;
        $this->passwordResetRequestRepository = $passwordResetRequestRepository;
        $this->validation = $validation;
    }

    final public function execute(ResetPasswordRequest $request): void
    {
        $this->validation->validate($request->toArray());

        $resetRequest = $this->passwordResetRequestRepository->hasUnexpiredOneForEmailAndCode($request->getEmail(), $request->getCode());

        if (!$resetRequest) {
            throw new PasswordResetRequestNotFoundException();
        }

        $user = $this->userRepository->findOneByEmailAddress($request->getEmail());

        if (!$user) {
            throw new UserNotFoundException();
        }

        $this->userRepository->updatePassword($user, Hash::make($user->getPassword()));
        $this->passwordResetRequestRepository->deleteByEmailAndCode($request->getEmail(), $request->getCode());
    }
}