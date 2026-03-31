<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Tour;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $tours = Tour::all();

        foreach ($tours as $tour) {

            $start = Carbon::now()->addDays(rand(5,30));
            $end = (clone $start)->addDays(rand(2,5));

            Trip::create([
                'tour_id' => $tour->id,
                'start_date' => $start,
                'end_date' => $end,
                'max_people' => rand(20,40),
                'current_people' => rand(0,10),
                'status' => 1
            ]);
        }
    }
}