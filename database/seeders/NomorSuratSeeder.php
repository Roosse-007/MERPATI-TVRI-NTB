<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NomorSurat;

class NomorSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'jenis_surat_id' => 1,
                'kode_nomor' => 'UMUM',
                'nomor_terakhir' => 0,
                'tahun' => date('Y'),
            ],

            [
                'jenis_surat_id' => 2,
                'kode_nomor' => 'NOTA',
                'nomor_terakhir' => 0,
                'tahun' => date('Y'),
            ],

            [
                'jenis_surat_id' => 3,
                'kode_nomor' => 'PROD',
                'nomor_terakhir' => 0,
                'tahun' => date('Y'),
            ],

        ];

        foreach ($data as $item) {
            NomorSurat::updateOrCreate(
                [
                    'jenis_surat_id' => $item['jenis_surat_id'],
                    'tahun' => $item['tahun'],
                ],
                $item
            );
        }
    }
}