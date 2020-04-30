<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class ResetPasswordValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required',
        ];
    }
}