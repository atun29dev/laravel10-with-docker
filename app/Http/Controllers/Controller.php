<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info (
 *     title = "Laravel 10 Swagger UI",
 *     version = "1.0",
 * ),
 * @OA\securitySchemes (
 *     type = "apiKey",
 *     description = "Enter token in format (Bearer <token>)",
 *     name = "Authorization",
 *     in = "header",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
