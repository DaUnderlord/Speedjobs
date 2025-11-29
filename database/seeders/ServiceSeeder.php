<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Service::create([
            'title' => 'Guidance & Assessment',
            'body' => 'Discover your strengths with our professional career planning tools and psychometric assessments.',
            'icon' => 'assessment',
        ]);

        \App\Models\Service::create([
            'title' => 'CV & Interview Clinic',
            'body' => 'Master the art of the interview and build a CV that gets you hired. We offer workshops on workplace ethics and readiness.',
            'icon' => 'cv',
        ]);

        \App\Models\Service::create([
            'title' => 'Mentorship & Networking',
            'body' => 'Connect with industry leaders and attend employer sessions to build your professional network.',
            'icon' => 'mentorship',
        ]);

        \App\Models\Service::create([
            'title' => 'Scholarships & Bursaries',
            'body' => 'We manage scholarship funds and apprenticeship stipends to support your learning journey.',
            'icon' => 'scholarship',
        ]);
    }
}
