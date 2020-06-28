<?php

declare(strict_types=1);

namespace App\UseCases\LogFoodConsumption;

/**
 * @OA\Schema(
 *     schema="LogFoodConsumptionRequest",
 *     title="Log food consumption request",
 *     required={"name"},
 *     properties={
 *          @OA\Property(property="name", type="string", example="Pasta"),
 *          @OA\Property(property="date_time", type="string")
 *     }
 * )
 */
final class LogFoodConsumptionRequest
{
    private $userId;

    private $name;

    private $dateTime;

    public function __construct($userId, $name, $dateTime)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->dateTime = $dateTime;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function toArray()
    {
        return [
            'user_id' => $this->getUserId(),
            'name' => $this->getName(),
            'date_time' => $this->getDateTime(),
        ];
    }
}