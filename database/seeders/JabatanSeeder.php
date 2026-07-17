<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

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
            'Admin',

        ];

        foreach ($data as $jabatan) {
            Jabatan::updateOrCreate(
                ['nama_jabatan' => $jabatan],
                ['is_active' => true]
            );
        }
    }
}