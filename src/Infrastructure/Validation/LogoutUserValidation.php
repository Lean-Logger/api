<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class LogoutUserValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'user_id' => 'required',
        ];
    }
}