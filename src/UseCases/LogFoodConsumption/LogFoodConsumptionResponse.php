<?php

declare(strict_types=1);

namespace App\UseCases\LogFoodConsumption;

use App\Domain\Food\FoodLog;

/**
 * @OA\Schema(
 *     schema="LogFoodConsumptionResponse",
 *     title="Log food consumption response",
 *     type="object",
 *     properties={
 *          @OA\Property(property="id", type="number", format="integer"),
 *          @OA\Property(property="user_id", type="number", format="integer"),
 *          @OA\Property(property="food", type="object", properties={
 *              @OA\Property(property="id", type="integer", nullable=false),
 *              @OA\Property(property="name", type="string", nullable=false)
 *          }),
 *          @OA\Property(property="date_time", type="string", format="date-time"),
 *          @OA\Property(property="created_at", type="string", format="date-time"),
 *          @OA\Property(property="updated_at", type="string", format="date-time")
 *     }
 * )
 */
final class LogFoodConsumptionResponse
{
    private $foodLog;

    public function __construct(FoodLog $foodLog)
    {
        $this->foodLog = $foodLog;
    }

    public function toArray(): array
    {
        return $this->foodLog->toArray();
    }
}