<?php

declare(strict_types=1);

namespace App\UseCases\LoginUser;

/**
 * @OA\Schema(
 *     schema="LoginUserResponse",
 *     title="Login User Response",
 *     type="object",
 *     properties={
 *          @OA\Property(property="login_token", type="string")
 *     }
 * )
 */
final class LoginUserResponse
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'login_token' => $this->token,
        ];
    }
}