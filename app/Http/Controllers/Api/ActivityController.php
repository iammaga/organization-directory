<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use OpenApi\Annotations as OA;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/activities/{activity}/organizations",
     *     summary="Get organizations by activity",
     *     tags={"Activities"},
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         description="ID of the activity",
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
    public function organizations(Activity $activity)
    {
        return OrganizationResource::collection($activity->organizations);
    }
}