<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
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

        User::create([
            'role' => RoleEnum::PROFESSOR_REGULAR,
            'nome' => 'Professor temporário',
            'email' => 'professor@exemplo.com',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'role' => RoleEnum::TECNICO,
            'nome' => 'Técnico temporário',
            'email' => 'tecnico@exemplo.com',
            'password' => Hash::make('123'),
        ]);
    }
}
