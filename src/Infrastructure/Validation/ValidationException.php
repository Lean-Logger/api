<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

use Illuminate\Contracts\Support\MessageBag;

final class ValidationException extends \UnexpectedValueException
{
    private $errors;

    public function __construct(MessageBag $errors)
    {
        parent::__construct('A validation error occurred');

        $this->errors = $errors;
    }

    public function getErrors(): MessageBag
    {
        return $this->errors;
    }
}