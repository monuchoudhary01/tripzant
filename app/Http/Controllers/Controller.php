<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Tripzant API Documentation",
 *      description="API endpoints for Tripzant Mobile App",
 *      @OA\Contact(
 *          email="support@tripzant.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url="http://127.0.0.1:8000/api/v1",
 *      description="Local Development Server"
 * )
 *
 * @OA\Server(
 *      url="https://tripnstays.com/api/v1",
 *      description="Staging/Live Server"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 * @OA\Tag(
 *     name="Flights",
 *     description="API Endpoints for Flight Search and Booking"
 * )
 * @OA\Tag(
 *     name="Hotels",
 *     description="API Endpoints for Hotel Search and Booking"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
