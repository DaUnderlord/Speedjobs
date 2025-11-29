<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Team::create([
            'name' => 'Ibem Kalu Idika',
            'role' => 'MD/CEO',
            'bio' => 'A seasoned HR & OD Consultant with over two decades of leadership across Banking, Telecoms, and Power sectors. Passionate about unlocking human potential and driving measurable business results.',
            'image' => null, // Placeholder
        ]);

        \App\Models\Team::create([
            'name' => 'Francisca Yetunde Armon',
            'role' => 'Director',
            'bio' => 'Managing Partner at Work Culture with 25 years of HR experience. A reading advocate and expert in employee relations, change management, and shaping positive work cultures.',
            'image' => null, // Placeholder
        ]);

        \App\Models\Team::create([
            'name' => 'Nsikak John Essien',
            'role' => 'Director, Learning Hub',
            'bio' => 'HR professional specializing in Talent Development and Strategy. Mentored over 100 graduates and leads our initiatives to position workplaces as learning organizations.',
            'image' => null, // Placeholder
        ]);

        \App\Models\Team::create([
            'name' => 'Amina Loretta Mohammed',
            'role' => 'Director, Media',
            'bio' => 'Communications expert with a decade of experience in high-profile corporate events and branding. Fluent in English, Hausa, and Yoruba, driving our brand visibility.',
            'image' => null, // Placeholder
        ]);
    }
}
