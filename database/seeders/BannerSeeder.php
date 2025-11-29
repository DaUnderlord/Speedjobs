<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Web Development Workshop',
                'description' => 'Join our intensive 3-day workshop on modern web development. Learn React, Node.js, and build real-world projects.',
                'type' => 'workshop',
                'is_active' => true,
                'order' => 1,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Data Science Training Program',
                'description' => 'Master Python, Machine Learning, and Data Analysis in our comprehensive 6-week training program.',
                'type' => 'training',
                'is_active' => true,
                'order' => 2,
                'start_date' => now(),
                'end_date' => now()->addDays(45),
            ],
            [
                'title' => 'Tech Career Fair 2025',
                'description' => 'Connect with top employers across Africa. Network, interview, and land your dream tech job.',
                'type' => 'event',
                'is_active' => true,
                'order' => 3,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(8),
            ],
            [
                'title' => 'Free Resume Review Session',
                'description' => 'Get your resume reviewed by industry experts. Limited slots available!',
                'type' => 'announcement',
                'is_active' => true,
                'order' => 4,
                'start_date' => now(),
                'end_date' => now()->addDays(14),
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
