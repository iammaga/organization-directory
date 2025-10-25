<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory(5)->create()->each(function ($activity) {
            Activity::factory(3)->create(['parent_id' => $activity->id])->each(function ($child1) {
                Activity::factory(2)->create(['parent_id' => $child1->id])->each(function ($child2) {
                    Activity::factory(1)->create(['parent_id' => $child2->id]);
                });
            });
        });
    }
}
