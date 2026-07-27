<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Surat Dinas',
            'Surat Perintah',
            'Nota Dinas',
            'Surat Edaran',
            'Surat Tugas',
            'Cuti Tahunan',
            'Cuti Melahirkan',
            'Naskah Dinas',
            'Surat Permohonan',
            'Surat Pengantar',
        ];

        foreach ($data as $nama) {
            JenisSurat::updateOrCreate(
                ['nama_jenis' => $nama],
                ['is_active' => true]
            );
        }
    }
}