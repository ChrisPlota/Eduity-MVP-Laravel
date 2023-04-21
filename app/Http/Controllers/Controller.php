<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Eduity API Documentation",
     *      description="Eduity Swagger API description",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Eduity API"
     * )
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Enter JWT authentication token",
     *     name="JWT Token",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
