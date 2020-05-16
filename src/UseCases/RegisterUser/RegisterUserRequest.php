<?php

declare(strict_types=1);

namespace App\UseCases\RegisterUser;

/**
 * @OA\Schema(
 *     schema="RegisterUserRequest",
 *     title="Register Request",
 *     required={"email", "password", "opt_in"},
 *     properties={
 *          @OA\Property(property="email", type="string", format="email", example="jax@redwood.com"),
 *          @OA\Property(property="password", type="string"),
 *          @OA\Property(property="opt_in", type="integer", enum={1, 0})
 *     }
 * )
 */
final class RegisterUserRequest
{
    private $email;

    private $password;

    private $optIn;

    public function __construct($email, $password, $optIn)
    {
        $this->email = $email;
        $this->password = $password;
        $this->optIn = $optIn;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getOptIn()
    {
        return $this->optIn;
    }

    public function toArray()
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'opt_in' => $this->getOptIn(),
        ];
    }
}