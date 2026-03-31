<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourCategory;

class TourCategorySeeder extends Seeder
{
    public function run(): void
    {
        TourCategory::insert([
            [
                'name' => 'Tour trong nước',
                'slug' => 'tour-trong-nuoc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tour nước ngoài',
                'slug' => 'tour-nuoc-ngoai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tour nghỉ dưỡng',
                'slug' => 'tour-nghi-duong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}