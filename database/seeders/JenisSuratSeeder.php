<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama_jenis' => 'Surat Masuk'],
            ['nama_jenis' => 'Surat Keluar'],
            ['nama_jenis' => 'Surat Internal'],
            ['nama_jenis' => 'Nota Dinas'],
            ['nama_jenis' => 'Surat Produksi'],
            ['nama_jenis' => 'Surat Undangan'],
            ['nama_jenis' => 'Surat Tugas'],

        ];

        foreach ($data as $item) {
            JenisSurat::firstOrCreate($item);
        }
    }
}