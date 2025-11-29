<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Technology', 'icon' => 'chip'],
            ['name' => 'Business', 'icon' => 'briefcase'],
            ['name' => 'Design', 'icon' => 'pencil'],
            ['name' => 'Marketing', 'icon' => 'speaker'],
            ['name' => 'Personal Development', 'icon' => 'user'],
        ];

        foreach ($categories as $cat) {
            CourseCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => 'Learn about ' . $cat['name'],
                    'icon' => $cat['icon'],
                ]
            );
        }

        // Create Courses
        $techCat = CourseCategory::where('slug', 'technology')->first();
        $businessCat = CourseCategory::where('slug', 'business')->first();

        $courses = [
            [
                'category_id' => $techCat->id,
                'title' => 'Complete Web Development Bootcamp',
                'description' => 'Become a full-stack web developer with just one course. HTML, CSS, Javascript, Node, React, MongoDB and more!',
                'long_description' => '<p>This is the only course you need to learn web development. We cover everything from the basics to advanced topics.</p><ul><li>HTML5 & CSS3</li><li>JavaScript ES6+</li><li>React & Redux</li><li>Node.js & Express</li><li>MongoDB</li></ul>',
                'instructor_name' => 'Dr. Angela Yu',
                'level' => 'beginner',
                'duration_hours' => 65,
                'price' => 25000,
                'is_free' => false,
                'is_published' => true,
                'rating' => 4.8,
                'total_reviews' => 1250,
            ],
            [
                'category_id' => $businessCat->id,
                'title' => 'The Complete MBA Course',
                'description' => 'Everything you need to know about business from start-up to IPO.',
                'long_description' => '<p>Master the foundations of business strategy, management, marketing, and accounting.</p>',
                'instructor_name' => 'Chris Haroun',
                'level' => 'intermediate',
                'duration_hours' => 40,
                'price' => 30000,
                'is_free' => false,
                'is_published' => true,
                'rating' => 4.6,
                'total_reviews' => 850,
            ],
            [
                'category_id' => $techCat->id,
                'title' => 'Introduction to Python Programming',
                'description' => 'Learn Python like a Professional! Start from the basics and go all the way to creating your own applications and games.',
                'long_description' => '<p>Python is one of the most popular programming languages in the world. This course will teach you everything you need to know.</p>',
                'instructor_name' => 'Jose Portilla',
                'level' => 'beginner',
                'duration_hours' => 25,
                'price' => 0,
                'is_free' => true,
                'is_published' => true,
                'rating' => 4.9,
                'total_reviews' => 2100,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create(array_merge($courseData, ['slug' => Str::slug($courseData['title'])]));

            // Create Lessons for each course
            for ($i = 1; $i <= 10; $i++) {
                CourseLesson::create([
                    'course_id' => $course->id,
                    'title' => 'Lesson ' . $i . ': Introduction to Topic ' . $i,
                    'slug' => Str::slug('Lesson ' . $i . ': Introduction to Topic ' . $i),
                    'content' => '<p>This is the content for lesson ' . $i . '. In this lesson, we will cover the fundamentals of the topic.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder video
                    'duration_minutes' => rand(10, 45),
                    'order' => $i,
                    'is_preview' => $i <= 2, // First 2 lessons are free preview
                ]);
            }
        }
    }
}
