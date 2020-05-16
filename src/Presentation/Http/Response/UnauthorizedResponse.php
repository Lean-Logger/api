<?php

declare(strict_types=1);

namespace App\Presentation\Http\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UnauthorizedResponse extends JsonResponse
{
    private const RESPONSE_CODE = Response::HTTP_UNAUTHORIZED;

    public function __construct()
    {
        parent::__construct([], self::RESPONSE_CODE, [], 0);
    }
}