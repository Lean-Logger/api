<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class LoginUserValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}