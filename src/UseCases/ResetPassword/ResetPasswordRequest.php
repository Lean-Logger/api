<?php

declare(strict_types=1);

namespace App\UseCases\ResetPassword;

/**
 * @OA\Schema(
 *     schema="ResetPasswordRequest",
 *     title="Reset Password Request",
 *     required={"email", "code", "password"},
 *     properties={
 *          @OA\Property(property="email", type="string", format="email"),
 *          @OA\Property(property="code", type="number", example="123456"),
 *          @OA\Property(property="password", type="string")
 *     }
 * )
 */
final class ResetPasswordRequest
{
    private $email;

    private $code;

    private $password;

    public function __construct($email, $code, $password)
    {
        $this->email = $email;
        $this->code = $code;
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function toArray()
    {
        return [
            'email' => $this->getEmail(),
            'code' => $this->getCode(),
            'password' => $this->getPassword(),
        ];
    }
}