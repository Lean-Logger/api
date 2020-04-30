<?php

declare(strict_types=1);

namespace App\UseCases\LoginUser;

/**
 * @OA\Schema(
 *     schema="LoginUserRequest",
 *     title="Login Request",
 *     required={"email", "password"},
 *     properties={
 *          @OA\Property(property="email", type="string", format="email", example="jax@redwood.com"),
 *          @OA\Property(property="password", type="string")
 *     }
 * )
 */
final class LoginUserRequest
{
    private $email;

    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function toArray()
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
    }
}