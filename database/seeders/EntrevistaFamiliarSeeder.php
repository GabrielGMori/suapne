<?php

namespace Database\Seeders;

use App\Models\EntrevistaFamiliar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrevistaFamiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EntrevistaFamiliar::factory(30)->create();
    }
}
