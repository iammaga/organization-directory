<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Building::all()->each(function ($building) {
            Organization::factory(rand(1, 5))->create([
                'building_id' => $building->id,
            ])->each(function ($organization) {
                $activities = Activity::inRandomOrder()->limit(rand(1, 5))->get();
                $organization->activities()->attach($activities);
            });
        });
    }
}