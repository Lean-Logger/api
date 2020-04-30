<?php

declare(strict_types=1);

namespace App\Presentation\Http\Response;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ValidationFailedResponse extends JsonResponse
{
    private const RESPONSE_CODE = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct(MessageBag $errors)
    {
        parent::__construct([
            'errors' => $errors->toArray()
        ], self::RESPONSE_CODE, [], 0);
    }
}