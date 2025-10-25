<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'lat',
        'lng',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}