<?php

use App\Domain\User\PasswordResetRequestRepositoryInterface;
use Carbon\Carbon;

class TestPasswordResetRequestData
{
    private $passwordResetRequestRepository;

    public function __construct(PasswordResetRequestRepositoryInterface $passwordResetRequestRepository)
    {
        $this->passwordResetRequestRepository = $passwordResetRequestRepository;
    }

    public function createPasswordResetRequest(string $email, ?int $code = null, ?DateTimeInterface $expiresAt = null): void
    {
        $expiresAt = $expiresAt ?? (new Carbon)->addDay();

        $this->passwordResetRequestRepository->create($email, $code ?? 123456, $expiresAt);
    }
}