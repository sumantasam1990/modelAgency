<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'state' => 2,
            'city' => 24,
            'district' => fake()->streetName,
            'wp' => fake()->phoneNumber,
            'gender' => fake()->randomElement(['male', 'female']),
            'civil' => fake()->randomElement(['single', 'married']),
            'username' => fake()->unique()->userName,
            'status' => fake()->randomElement([0, 1]),
            'subscribed' => fake()->randomElement([0, 1]),
            'payment_card_id' => fake()->creditCardNumber,
            'preferences' => json_encode(['preference1' => fake()->randomElement(['value1', 'value2']), 'preference2' => fake()->randomElement(['value3', 'value4'])]),
            'age' => fake()->numberBetween(18, 65),
            'bust' => fake()->numberBetween(30, 50),
            'eyes' => fake()->randomElement(['Hazel', 'Black']),
            'hips' => fake()->numberBetween(30, 50),
            'skin' => fake()->randomElement(['Brown', 'Black']),
            'dress' => fake()->randomElement(['1', '2', '4', '10']),
            'other' => 'fitness,tatoo',
            'waist' => fake()->numberBetween(20, 40),
            'height' => fake()->numberBetween(150, 200) / 100,
            'hair' => fake()->randomElement(['Blond', 'Brown', 'Black']),
        ];
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
