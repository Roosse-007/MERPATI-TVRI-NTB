<?php

namespace App\Services;


use App\Models\Surat;
use App\Models\TemplateSurat;

use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpWord\TemplateProcessor;



class SuratGeneratorService
{


    public function generate(
        Surat $surat
    )
    {


        /*
        |--------------------------------------------------------------------------
        | Ambil Template DOCX
        |--------------------------------------------------------------------------
        */


        $template = TemplateSurat::findOrFail(
            $surat->template_surat_id
        );



        $templatePath =
            storage_path(
                'app/public/'.$template->file_template
            );





        /*
        |--------------------------------------------------------------------------
        | Buka DOCX Template
        |--------------------------------------------------------------------------
        */


        $processor = new TemplateProcessor(
            $templatePath
        );






        /*
        |--------------------------------------------------------------------------
        | Replace Placeholder
        |--------------------------------------------------------------------------
        */


        $processor->setValue(
            'NOMOR_SURAT',
            $surat->nomor_surat
        );


        $processor->setValue(
            'PERIHAL',
            $surat->perihal
        );


        $processor->setValue(
            'TANGGAL',
            $surat->tanggal_surat
                ->format('d M Y')
        );


        $processor->setValue(
            'ISI_SURAT',
            strip_tags($surat->isi_surat)
        );







        /*
        |--------------------------------------------------------------------------
        | Simpan DOCX Hasil
        |--------------------------------------------------------------------------
        */


        $folder =
            'surat/docx';



        Storage::disk('public')
            ->makeDirectory($folder);




        $fileName =
            'surat-'.$surat->id.'.docx';



        $path =
            $folder.'/'.$fileName;




        $processor->saveAs(

            storage_path(
                'app/public/'.$path
            )

        );






        /*
        |--------------------------------------------------------------------------
        | Update Surat
        |--------------------------------------------------------------------------
        */


        $surat->update([

            'file_surat'=>$path

        ]);





        return $path;


    }


}