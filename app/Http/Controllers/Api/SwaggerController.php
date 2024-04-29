<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends Controller
{
    /**
     * This is tests API endpoint by Swagger
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get (
     *     path = "/api/v1",
     *     summary = "This is tests API endpoint",
     *     tags = {"Index"},
     *     @OA\Response (
     *         response = "200",
     *         description = "Request is successful"
     *     )
     * )
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'This is API endpoint environment'
        ], Response::HTTP_OK);
    }
}
