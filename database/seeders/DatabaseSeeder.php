<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            RoleSeeder::class,

            PermissionSeeder::class,

            UnitKerjaSeeder::class,

            JabatanSeeder::class,

            JenisSuratSeeder::class,

            SifatSuratSeeder::class,

            PrioritasSuratSeeder::class,

            TemplateSuratSeeder::class,

            NomorSuratSeeder::class,

            UserSeeder::class,

        ]);
    }
}