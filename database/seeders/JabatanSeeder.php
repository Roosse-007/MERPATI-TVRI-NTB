<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'nama_jabatan' => 'Kepala TVRI Stasiun NTB',
                'level_jabatan' => 4,
            ],

            [
                'nama_jabatan' => 'Kepala Sub Bagian Tata Usaha',
                'level_jabatan' => 3,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Berita',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Program',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Teknik',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Pengembangan Usaha',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Konten Media Baru',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Promo',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana dan Pengendali Keuangan',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'Ketua Tim Perencana Pengendali dan Pengembangan Umum',
                'level_jabatan' => 2,
            ],

            [
                'nama_jabatan' => 'PPK 1',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'PPK 2',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'PPBJ',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'Humas',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'Dokpus',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'Produser',
                'level_jabatan' => 1,
            ],

            [
                'nama_jabatan' => 'Admin',
                'level_jabatan' => 1,
            ],

        ];

        foreach ($data as $item) {
            Jabatan::updateOrCreate(
                ['nama_jabatan' => $item['nama_jabatan']],
                $item
            );
        }
    }
}