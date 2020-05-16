<?php

declare(strict_types=1);

namespace App\UseCases\RegisterUser;

use App\Domain\User\User;

/**
 * @OA\Schema(
 *     schema="RegisterUserResponse",
 *     title="Register User Response",
 *     type="object",
 *     properties={
 *          @OA\Property(property="email", type="string"),
 *          @OA\Property(property="opt_in", type="integer", enum={0, 1}),
 *          @OA\Property(property="created_at", type="string", format="date-time"),
 *     }
 * )
 */
final class RegisterUserResponse
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return $this->user->toArray();
    }
}