<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitKerja;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama_unit'=>'Kepala TVRI'],

            ['nama_unit'=>'Tata Usaha'],

            ['nama_unit'=>'Berita'],

            ['nama_unit'=>'Program'],

            ['nama_unit'=>'Teknik'],

            ['nama_unit'=>'Pengembangan Usaha'],

            ['nama_unit'=>'Konten Media Baru'],

            ['nama_unit'=>'Promo'],

            ['nama_unit'=>'Keuangan'],

            ['nama_unit'=>'Umum'],

            ['nama_unit'=>'PPK'],

            ['nama_unit'=>'PPBJ'],

            ['nama_unit'=>'Humas'],

            ['nama_unit'=>'Dokumentasi dan Perpustakaan'],

            ['nama_unit'=>'Produksi'],

        ];

        foreach ($data as $item){

            UnitKerja::create($item);

        }
    }
}