<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = ['Software Engineer', 'Product Manager', 'Data Analyst', 'UX Designer', 'Marketing Specialist', 'Sales Manager', 'Accountant', 'HR Manager'];
        $categories = ['Technology', 'Finance', 'Healthcare', 'Marketing', 'Sales', 'Design', 'Engineering', 'Education'];
        $types = ['Full-time', 'Part-time', 'Contract', 'Remote'];
        $locations = ['Lagos, Nigeria', 'Nairobi, Kenya', 'Accra, Ghana', 'Cape Town, South Africa', 'Remote'];

        return [
            'title' => $this->faker->randomElement($jobTitles),
            'company' => $this->faker->company,
            'location' => $this->faker->randomElement($locations),
            'type' => $this->faker->randomElement($types),
            'category' => $this->faker->randomElement($categories),
            'salary_range' => '$' . $this->faker->numberBetween(1000, 5000) . ' - $' . $this->faker->numberBetween(6000, 10000),
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'is_featured' => $this->faker->boolean(20),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
