<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
        return [
            'title' => fake()->jobTitle(),
            'cover_image' => 'images/job/cover/cover.png',
            'backdrop_image' => 'images/job/backdrop/backdrop.png',
            'location' => fake()->address(),
            'time_type' => fake()->randomElement(['full time', 'part time']),
            'salary' => 2000000,
            'company_id' => 1,
            'gender' => fake()->randomElement(['pria', 'wanita', 'bebas']),
            'education' => fake()->randomElement(['smp', 'sma', 'smk', 'bebas']),
            'minimum_age' => fake()->numberBetween(15, 20),
            'maximum_age' => fake()->numberBetween(30, 40),
            'description' => fake()->paragraph(),
            'pkl_status' => fake()->randomElement([0, 1]),
            'confirmed_status' => 'menunggu',
        ];
    }
}
