<?php

declare(strict_types=1);

namespace App\Presentation\Http\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreatedResponse extends JsonResponse
{
    private const RESPONSE_CODE = Response::HTTP_CREATED;

    public function __construct($data = null)
    {
        parent::__construct($data, self::RESPONSE_CODE, [], 0);
    }
}