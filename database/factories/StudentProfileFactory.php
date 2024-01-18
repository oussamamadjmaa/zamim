<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'parent_name' => fake('ar_SA')->name(),
            'parent_email' => fake()->unique()->safeEmail(),
            'level' => fake()->randomElement(['إبتدائي', 'متوسط', 'ثانوي']),
            'class' => fake()->randomElement(['الأول', 'الثاني', 'الثالث', 'الرابع']),
            'division' => fake()->randomElement(['أ', 'ب', 'ج', 'ح']),
        ];
    }
}
