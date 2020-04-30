<?php

declare(strict_types=1);

namespace App\UseCases\RequestPasswordReset;

use App\Domain\User\PasswordResetRequestRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\TokenGenerator;
use App\Infrastructure\Validation\RequestPasswordResetValidation;
use Carbon\Carbon;

final class RequestPasswordResetUseCase
{
    private const EXPIRES_IN_MINUTES = 30;

    private $userRepository;

    private $validation;

    private $tokenGenerator;

    private $passwordResetRequestRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PasswordResetRequestRepositoryInterface $passwordResetRequestRepository,
        RequestPasswordResetValidation $validation,
        TokenGenerator $tokenGenerator
    ){
        $this->userRepository = $userRepository;
        $this->passwordResetRequestRepository = $passwordResetRequestRepository;
        $this->validation = $validation;
        $this->tokenGenerator = $tokenGenerator;
    }

    final public function execute(RequestPasswordResetRequest $request): void
    {
        $this->validation->validate($request->toArray());

        $user = $this->userRepository->findOneByEmailAddress($request->getEmail());

        if (!$user) {
            return;
        }

        $code = (int) $this->tokenGenerator
            ->setAlphabet(implode(range(0, 9)))
            ->generate(6)
        ;

        $expiresAt = (new Carbon())->addMinutes(self::EXPIRES_IN_MINUTES);

        $this->passwordResetRequestRepository->create(
            $user->getEmail(),
            $code,
            $expiresAt
        );
    }
}