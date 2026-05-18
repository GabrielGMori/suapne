<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['PROFESSOR_REGULAR', 'DOCENTE_ESPECIAL', 'TECNICO']),
            'password' => static::$password ??= Hash::make('password'),
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' . urlencode(fake()->userName()),
        ];
    }
}
