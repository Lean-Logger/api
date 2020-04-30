<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class RequestPasswordResetValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}