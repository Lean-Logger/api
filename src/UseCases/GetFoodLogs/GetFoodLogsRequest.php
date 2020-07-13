<?php

declare(strict_types=1);

namespace App\UseCases\GetFoodLogs;

/**
 * @OA\Schema(
 *     schema="GetFoodLogsRequest",
 *     title="Get food logs request",
 *     properties={
 *          @OA\Property(property="date", type="string")
 *     }
 * )
 */
final class GetFoodLogsRequest
{
    private $userId;

    private $date;

    public function __construct($userId, $date)
    {
        $this->userId = $userId;
        $this->date = $date;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function toArray()
    {
        return [
            'user_id' => $this->getUserId(),
            'date' => $this->getDate(),
        ];
    }
}