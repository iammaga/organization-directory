<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    /**
     * Get all descendant activity IDs for the current activity.
     *
     * @param int $maxDepth The maximum depth to search for descendants.
     * @param int $currentDepth The current depth in the recursion.
     * @return array
     */
    public function getDescendantIds(int $maxDepth = 3, int $currentDepth = 0): array
    {
        $descendantIds = [$this->id];

        if ($currentDepth < $maxDepth) {
            foreach ($this->children as $child) {
                $descendantIds = array_merge($descendantIds, $child->getDescendantIds($maxDepth, $currentDepth + 1));
            }
        }

        return array_unique($descendantIds);
    }
}
