<?php

declare(strict_types=1);

namespace App\UseCases\RequestPasswordReset;

/**
 * @OA\Schema(
 *     schema="RequestPasswordResetRequest",
 *     title="Request Password Reset Request",
 *     required={"email"},
 *     properties={
 *          @OA\Property(property="email", type="string", format="email")
 *     }
 * )
 */
final class RequestPasswordResetRequest
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function toArray()
    {
        return [
            'email' => $this->getEmail(),
        ];
    }
}