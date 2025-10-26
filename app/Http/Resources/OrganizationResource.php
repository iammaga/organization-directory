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
 *         property="phones",
 *         type="array",
 *         @OA\Items(type="string"),
 *         description="List of phone numbers for the organization"
 *     ),
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *         @OA\Items(type="string"),
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
            'phones' => $this->whenLoaded('phones', function () {
                return $this->phones->pluck('phone');
            }),
            'activities' => $this->whenLoaded('activities', function () {
                return $this->activities->pluck('name');
            }),
        ];
    }
}
