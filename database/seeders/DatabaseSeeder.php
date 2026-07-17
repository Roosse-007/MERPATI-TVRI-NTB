<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            // Spatie Role & Permission
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,

            // Master Data
            UnitKerjaSeeder::class,
            JabatanSeeder::class,

            // Surat
            JenisSuratSeeder::class,
            SifatSuratSeeder::class,
            PrioritasSuratSeeder::class,
            TemplateSuratSeeder::class,
            NomorSuratSeeder::class,

            // User terakhir karena membutuhkan role, unit, jabatan
            UserSeeder::class,

        ]);
    }
}