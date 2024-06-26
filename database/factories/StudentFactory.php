<?php

namespace Database\Factories;

use App\Models\StudentProfile;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'school_id' => 1,
            'name' => fake('ar_SA')->firstName() . ' ' . fake('ar_SA')->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => "+9665".substr(preg_replace('/[^0-9]/', '', fake()->unique()->phoneNumber()), -8),
            'email_verified_at' => now(),
            'role'  => 'student',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Student $student) {
            $student->profile()->create(StudentProfile::factory()->raw());
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
