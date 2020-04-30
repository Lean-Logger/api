<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class RegisterUserValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'opt_in' => 'in:0,1',
        ];
    }
}