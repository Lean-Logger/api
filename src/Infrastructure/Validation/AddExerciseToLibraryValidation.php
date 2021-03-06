<?php

declare(strict_types=1);

namespace App\Infrastructure\Validation;

final class AddExerciseToLibraryValidation extends AbstractValidation
{
    protected function getValidationRules(): array
    {
        return [
            'name' => 'required',
            'description' => 'nullable',
            'type' => 'required|in:weighted_reps,non_weighted_reps,duration',
        ];
    }
}