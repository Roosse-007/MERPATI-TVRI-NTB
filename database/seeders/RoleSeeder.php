<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [

            'Admin',

            'Kepala TVRI Stasiun NTB',

            'Kepala Sub Bagian Tata Usaha',

            'Ketua Tim Perencana dan Pengendali Berita',

            'Ketua Tim Perencana dan Pengendali Program',

            'Ketua Tim Perencana dan Pengendali Teknik',

            'Ketua Tim Perencana dan Pengendali Pengembangan Usaha',

            'Ketua Tim Perencana dan Pengendali Konten Media Baru',

            'Ketua Tim Perencana dan Pengendali Promo',

            'Ketua Tim Perencana dan Pengendali Keuangan',

            'Ketua Tim Perencana Pengendali dan Pengembangan Umum',

            'PPK 1',

            'PPK 2',

            'PPBJ',

            'Humas',

            'Dokpus',

            'Produser',
        ];

        foreach ($roles as $role) {

            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);

        }
    }
}