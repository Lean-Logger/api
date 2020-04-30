<?php

declare(strict_types=1);

namespace App\UseCases\LogoutUser;

/**
 * @OA\Schema(
 *     schema="LogoutUserRequest",
 *     title="Logout Request",
 *     required={"user_id"},
 *     properties={
 *          @OA\Property(property="user_id", type="number")
 *     }
 * )
 */
final class LogoutUserRequest
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function toArray()
    {
        return [
            'user_id' => $this->getUserId(),
        ];
    }
}