<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="OrganizationResource",
 *     title="Organization Resource",
 *     description="Organization resource model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the organization"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the organization"
 *     ),
 *     @OA\Property(
 *         property="building",
 *         ref="#/components/schemas/BuildingResource",
 *         description="Building where the organization is located"
 *     ),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/OrganizationPhoneResource"),
 *         description="List of phone numbers for the organization"
 *     ),
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ActivityResource"),
 *         description="List of activities associated with the organization"
 *     )
 * )
 */
class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'phones' => OrganizationPhoneResource::collection($this->whenLoaded('phones')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
