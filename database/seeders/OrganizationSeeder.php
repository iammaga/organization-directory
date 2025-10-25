<?php

namespace Database\Seeders;

use App\Models\Activity;
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
        Organization::factory(20)->create()->each(function ($organization) {
            $activities = Activity::inRandomOrder()->limit(rand(1, 5))->get();
            $organization->activities()->attach($activities);
        });
    }
}