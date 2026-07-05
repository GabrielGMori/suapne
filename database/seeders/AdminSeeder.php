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
    }
}
