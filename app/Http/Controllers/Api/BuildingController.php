<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Building;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Organization Directory API Documentation",
 *      description="API documentation for the Organization Directory project",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Organization Directory API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-API-KEY",
 *     securityScheme="ApiKeyAuth"
 * )
 */
class BuildingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/buildings",
     *     summary="Get all buildings",
     *     tags={"Buildings"},
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BuildingResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return BuildingResource::collection(Building::all());
    }

    /**
     * @OA\Get(
     *     path="/buildings/{building}/organizations",
     *     summary="Get organizations by building",
     *     tags={"Buildings"},
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(
     *         name="building",
     *         in="path",
     *         required=true,
     *         description="ID of the building",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OrganizationResource")
     *         )
     *     )
     * )
     */
    public function organizations(Building $building)
    {
        return OrganizationResource::collection($building->organizations);
    }
}