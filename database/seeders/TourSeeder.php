<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {

            $name = "Tour du lịch số " . $i;

            Tour::create([
                'category_id' => rand(1,3),
                'name' => $name,
                'slug' => Str::slug($name),
                'departure_location' => 'Hà Nội',
                'destination' => collect([
                    'Đà Lạt',
                    'Phú Quốc',
                    'Nha Trang',
                    'Đà Nẵng',
                    'Sapa',
                    'Hạ Long'
                ])->random(),
                'duration' => rand(2,5) . ' ngày ' . rand(1,4) . ' đêm',
                'transport' => collect(['Máy bay','Xe khách','Tàu hoả'])->random(),
                'price' => rand(2000000,8000000),
                'child_price' => rand(1000000,4000000),
                'max_people' => rand(20,40),
                'description' => 'Tour du lịch trải nghiệm tuyệt vời với nhiều địa điểm hấp dẫn.',
                'highlight' => 'Check-in đẹp, khách sạn 4 sao, ăn uống đặc sản địa phương.',
                'thumbnail' => 'tours/default.jpg',
                'status' => 1,
                'views' => rand(0,500)
            ]);

        }
    }
}