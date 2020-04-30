<?php

declare(strict_types=1);

namespace App\Presentation\Http\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class NotFoundResponse extends JsonResponse
{
    private const RESPONSE_CODE = Response::HTTP_NOT_FOUND;

    public function __construct(string $message)
    {
        parent::__construct(['error' => $message], self::RESPONSE_CODE, [], 0);
    }
}