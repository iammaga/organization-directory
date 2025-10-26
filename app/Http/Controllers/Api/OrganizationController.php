<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/organizations/{organization}",
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID of the organization",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/OrganizationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organization not found"
     *     )
     * )
     */
    public function show(Organization $organization)
    {
        $organization->load('building', 'phones', 'activities');
        return new OrganizationResource($organization);
    }

    /**
     * @OA\Get(
     *     path="/organizations/search",
     *     summary="Search organizations by activity or name",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="activity",
     *         in="query",
     *         required=false,
     *         description="Activity name to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Organization name to search for",
     *         @OA\Schema(type="string")
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
    public function search(Request $request)
    {
        $query = Organization::query();

        if ($request->has('activity')) {
            $activityName = $request->activity;
            $matchingActivities = \App\Models\Activity::where('name', 'like', '%' . $activityName . '%')->get();

            $activityIds = collect();
            foreach ($matchingActivities as $activity) {
                $activityIds = $activityIds->merge($activity->getDescendantIds());
            }

            $query->whereHas('activities', function ($q) use ($activityIds) {
                $q->whereIn('id', $activityIds->unique()->toArray());
            });
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        return OrganizationResource::collection($query->get());
    }

    /**
     * @OA\Get(
     *     path="/organizations/nearby",
     *     summary="Get organizations nearby a given location",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         required=true,
     *         description="Latitude of the center point",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="lng",
     *         in="query",
     *         required=true,
     *         description="Longitude of the center point",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         required=true,
     *         description="Radius in kilometers",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OrganizationResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function nearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius;

        $organizations = Organization::with('building')
            ->select(DB::raw("organizations.*, ( 6371 * acos( cos( radians(?) ) * cos( radians( buildings.lat ) ) * cos( radians( buildings.lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( buildings.lat ) ) ) ) AS distance"))
            ->join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->having("distance", "<", $radius)
            ->orderBy("distance")
            ->setBindings([$lat, $lng, $lat])
            ->get();

        return OrganizationResource::collection($organizations);
    }
}