<?php

declare(strict_types=1);

namespace App\UseCases\GetFoodLogs;

use App\Domain\Food\FoodLog;

/**
 * @OA\Schema(
 *     schema="GetFoodLogsResponse",
 *     title="Get Food Logs Response",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/LogFoodConsumptionResponse")
 * )
 */
final class GetFoodLogsResponse
{
    private $foodLogs;

    public function __construct(array $foodLogs)
    {
        $this->foodLogs = $foodLogs;
    }

    public function toArray(): array
    {
        return [
            'items' => array_map(function(FoodLog $foodLog) {
                return $foodLog->toArray();
            }, $this->foodLogs),
        ];
    }
}