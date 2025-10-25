<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ActivityResource",
 *     title="Activity Resource",
 *     description="Activity resource model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the activity"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the activity"
 *     ),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ActivityResource"),
 *         description="Child activities"
 *     )
 * )
 */
class ActivityResource extends JsonResource
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
            'children' => $this->when($this->relationLoaded('children'), function () {
                return ActivityResource::collection($this->children);
            }),
        ];
    }
}
