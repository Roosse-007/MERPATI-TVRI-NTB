<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrioritasSurat;

class PrioritasSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'nama_prioritas' => 'Rendah',
                'urutan' => 4,
            ],

            [
                'nama_prioritas' => 'Sedang',
                'urutan' => 3,
            ],

            [
                'nama_prioritas' => 'Tinggi',
                'urutan' => 2,
            ],

            [
                'nama_prioritas' => 'Sangat Tinggi',
                'urutan' => 1,
            ],

        ];

        foreach ($data as $item) {
            PrioritasSurat::updateOrCreate(
                ['nama_prioritas' => $item['nama_prioritas']],
                $item
            );
        }
    }
}