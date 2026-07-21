<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SifatSurat;

class SifatSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_sifat' => 'Biasa',
                'deskripsi' => 'Surat dengan prioritas normal.'
            ],
            [
                'nama_sifat' => 'Terbatas',
                'deskripsi' => 'Hanya untuk pihak tertentu.'
            ],
            [
                'nama_sifat' => 'Penting',
                'deskripsi' => 'Memerlukan perhatian khusus.'
            ],
            [
                'nama_sifat' => 'Segera',
                'deskripsi' => 'Harus segera ditindaklanjuti.'
            ],
            [
                'nama_sifat' => 'Rahasia',
                'deskripsi' => 'Informasi bersifat rahasia.'
            ],
        ];

        foreach ($data as $item) {
            SifatSurat::updateOrCreate(
                ['nama_sifat' => $item['nama_sifat']],
                ['deskripsi' => $item['deskripsi']]
            );
        }
    }
}