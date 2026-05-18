<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Disciplina;
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
            'role' => fake()->randomElement(RoleEnum::cases()),
            'password' => static::$password ??= Hash::make('password'),
            'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' . urlencode(fake()->userName()),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {

            if ($user->role !== RoleEnum::PROFESSOR_REGULAR) {
                return;
            }

            $disciplinas = Disciplina::query()
                ->inRandomOrder('')
                ->limit(rand(1, min(5, Disciplina::count(3))))
                ->pluck('id')
                ->toArray();

            $user->disciplinas()->attach($disciplinas);
        });
    }
}
