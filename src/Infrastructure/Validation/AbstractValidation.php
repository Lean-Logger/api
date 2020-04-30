<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

use Illuminate\Support\Facades\Validator;

abstract class AbstractValidation
{
    public function validate(array $data): bool
    {
        $validator = Validator::make(
            $data,
            $this->getValidationRules()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator->getMessageBag());
        }

        return true;
    }

    abstract protected function getValidationRules(): array;
}