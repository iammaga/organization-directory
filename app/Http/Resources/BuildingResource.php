<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="BuildingResource",
 *     title="Building Resource",
 *     description="Building resource model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the building"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the building"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the building"
 *     ),
 *     @OA\Property(
 *         property="lat",
 *         type="number",
 *         format="float",
 *         description="Latitude of the building"
 *     ),
 *     @OA\Property(
 *         property="lng",
 *         type="number",
 *         format="float",
 *         description="Longitude of the building"
 *     )
 * )
 */
class BuildingResource extends JsonResource
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
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
