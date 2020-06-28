<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class LogFoodConsumptionValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'name' => 'required',
            'date_time' => 'nullable',
        ];
    }
}