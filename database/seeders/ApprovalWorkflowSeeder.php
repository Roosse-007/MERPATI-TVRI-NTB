<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApprovalWorkflow;
use App\Models\JenisSurat;
use App\Models\Jabatan;

class ApprovalWorkflowSeeder extends Seeder
{
   public function run(): void
{
    ApprovalWorkflow::query()->delete();

    $jenisSurat = JenisSurat::all();

        foreach ($jenisSurat as $jenis) {

            $workflow = [

                [
                    'jabatan' => 'Ketua Tim Perencana dan Pengendali Program',
                    'urutan' => 1,
                ],

                [
                    'jabatan' => 'Kepala Sub Bagian Tata Usaha',
                    'urutan' => 2,
                ],

                [
                    'jabatan' => 'Kepala TVRI Stasiun NTB',
                    'urutan' => 3,
                ],

            ];

            foreach ($workflow as $item) {

                $jabatan = Jabatan::where(
                    'nama_jabatan',
                    $item['jabatan']
                )->first();

                if (!$jabatan) {
                    continue;
                }

                ApprovalWorkflow::create([

                    'jenis_surat_id' => $jenis->id,

                    'jabatan_id' => $jabatan->id,

                    'urutan' => $item['urutan'],

                    'aktif' => true,

                ]);
            }
        }
    }
}