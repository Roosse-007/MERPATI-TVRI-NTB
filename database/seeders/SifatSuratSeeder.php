<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SifatSurat;

class SifatSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama_sifat' => 'Biasa'],
            ['nama_sifat' => 'Penting'],
            ['nama_sifat' => 'Rahasia'],
            ['nama_sifat' => 'Sangat Rahasia'],

        ];

        foreach ($data as $item) {
            SifatSurat::firstOrCreate($item);
        }
    }
}