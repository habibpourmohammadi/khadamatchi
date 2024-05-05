<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random city from the database
        $city = City::inRandomOrder()->first();

        // Determine a random gender ('male' or 'female')
        $gender = $this->getRandomGender();

        return [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName(),
            'mobile' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'city_id' => $city->id,
            'province_id' => $city->province_id,
            'account_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            "gender" => $gender,
        ];
    }

    /**
     * Get a random gender ('male' or 'female').
     */
    function getRandomGender(): string
    {
        $genders = ['male', 'female'];
        $randomIndex = array_rand($genders);

        return $genders[$randomIndex];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
