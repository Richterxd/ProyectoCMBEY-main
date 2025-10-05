<?php

namespace Database\Seeders;

use App\Models\Sectores;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SecurityQuestionSeeder::class,
            RoleSeeder::class,
            AmbitoSeeder::class,
            SectoresSeeder::class,
            InstitucionSeeder::class,
            UserSeeder::class,
            SolicitudesSeeder::class,
        ]);
    }
}