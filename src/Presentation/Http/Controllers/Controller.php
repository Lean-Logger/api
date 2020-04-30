<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Lean Logger API", version="1.0")
 */
/**
 * @OA\Components(
 *     responses={
 *          @OA\Response(response="ServerError", description="Unexpected Server Error", @OA\JsonContent(ref="#/components/schemas/ErrorsObject")),
 *          @OA\Response(response="NotFound", description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/ErrorsObject")),
 *          @OA\Response(response="Unauthorized", description="Unauthorized request or invalid credentials", @OA\JsonContent(ref="#/components/schemas/ErrorsObject")),
 *          @OA\Response(response="Forbidden", description="Forbidden Request. The operation cannot be completed.", @OA\JsonContent(ref="#/components/schemas/ErrorsObject")),
 *          @OA\Response(response="BadRequest", description="Invalid Request Data", @OA\JsonContent(ref="#/components/schemas/ErrorsObject")),
 *     }
 * )
 */

/**
 * @OA\Schema(
 *     schema="ErrorsObject",
 *     title="API Errors",
 *     type="object",
 *     properties={
 *        @OA\Property(property="errors", type="array", @OA\Items(
 *            type="object",
 *            required={"title", "code"},
 *            properties={
 *               @OA\Property(property="title", type="string", description="Error message"),
 *               @OA\Property(property="code", type="string", nullable=true, description="Error code"),
 *               @OA\Property(property="source", type="string", nullable=true, description="Property path where the error occurred, if applicable"),
 *            }
 *        ))
 *     }
 * )
 */
class Controller extends BaseController
{
    //
}
