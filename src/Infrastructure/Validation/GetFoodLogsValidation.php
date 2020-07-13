<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class GetFoodLogsValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'date' => 'required',
        ];
    }
}