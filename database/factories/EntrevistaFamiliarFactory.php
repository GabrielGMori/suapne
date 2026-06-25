<?php

namespace Database\Factories;

use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EntrevistaFamiliar>
 */
class EntrevistaFamiliarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudante = Estudante::query()->inRandomOrder()->first();
        $user = User::query()->inRandomOrder()->first();

        return [
            'data' => $this->faker->dateTimeBetween('-10 year'),
            'estudante_id' => $estudante->id,
            'user_id' => $user->id,
            'campos' => [],
        ];
    }
}
