<?php

namespace Database\Seeders;

use App\Models\Counselor;
use App\Models\CounselorAvailability;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CounselorSeeder extends Seeder
{
    public function run(): void
    {
        $counselors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'specialization' => 'Career Transition',
                'bio' => 'Dr. Sarah Johnson is a certified career counselor with over 15 years of experience helping professionals navigate career changes. She specializes in identifying transferable skills and creating strategic career roadmaps.',
                'experience_years' => 15,
                'hourly_rate' => 15000,
                'certifications' => json_encode(['Certified Career Counselor (CCC)', 'Global Career Development Facilitator (GCDF)']),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@example.com',
                'specialization' => 'Tech Industry',
                'bio' => 'Michael is a former Google recruiter turned career coach. He helps software engineers and product managers land their dream roles at top tech companies. His expertise includes resume optimization and technical interview prep.',
                'experience_years' => 8,
                'hourly_rate' => 20000,
                'certifications' => json_encode(['Certified Professional Resume Writer (CPRW)']),
            ],
            [
                'name' => 'Amara Okeke',
                'email' => 'amara.okeke@example.com',
                'specialization' => 'Executive Leadership',
                'bio' => 'Amara works with senior executives to enhance their leadership presence and strategic thinking. She has a background in organizational psychology and has coached leaders across Africa.',
                'experience_years' => 12,
                'hourly_rate' => 25000,
                'certifications' => json_encode(['ICF Professional Certified Coach (PCC)']),
            ],
            [
                'name' => 'David Miller',
                'email' => 'david.miller@example.com',
                'specialization' => 'Interview Coaching',
                'bio' => 'David is an expert in interview psychology. He helps candidates overcome anxiety and communicate their value effectively. He has conducted over 5000 mock interviews.',
                'experience_years' => 10,
                'hourly_rate' => 12000,
                'certifications' => json_encode(['Certified Interview Coach (CIC)']),
            ],
        ];

        foreach ($counselors as $data) {
            // Create User
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );

            // Create Counselor Profile
            $counselor = Counselor::create([
                'user_id' => $user->id,
                'specialization' => $data['specialization'],
                'bio' => $data['bio'],
                'experience_years' => $data['experience_years'],
                'hourly_rate' => $data['hourly_rate'],
                'rating' => rand(45, 50) / 10,
                'is_active' => true,
                'certifications' => $data['certifications'],
            ]);

            // Create Availability (Mon-Fri, 9-5)
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            foreach ($days as $day) {
                CounselorAvailability::create([
                    'counselor_id' => $counselor->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_active' => true,
                ]);
            }
        }
    }
}
