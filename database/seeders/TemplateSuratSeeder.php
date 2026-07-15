<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateSurat;

class TemplateSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'nama_template' => 'Template Surat Dinas',
                'file_template' => 'template_surat_dinas.docx',
                'keterangan' => 'Template standar surat dinas TVRI NTB',
                'is_active' => true,
            ],

            [
                'nama_template' => 'Template Nota Dinas',
                'file_template' => 'template_nota_dinas.docx',
                'keterangan' => 'Template standar nota dinas',
                'is_active' => true,
            ],

            [
                'nama_template' => 'Template Surat Produksi',
                'file_template' => 'template_surat_produksi.docx',
                'keterangan' => 'Template surat produksi program',
                'is_active' => true,
            ],

        ];

        foreach ($data as $item) {
            TemplateSurat::updateOrCreate(
                ['nama_template' => $item['nama_template']],
                $item
            );
        }
    }
}