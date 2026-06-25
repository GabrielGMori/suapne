<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role' => RoleEnum::DOCENTE_ESPECIAL,
            'nome' => 'Admin temporário',
            'email' => 'admin@exemplo.com',
            'password' => Hash::make('123'),
        ]);
        User::factory(2)->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
        User::factory(4)->create(['role' => RoleEnum::TECNICO]);
        User::factory(12)->create(['role' => RoleEnum::PROFESSOR_REGULAR]);
    }
}
