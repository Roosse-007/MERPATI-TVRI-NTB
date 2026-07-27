<?php

namespace App\Services;


use App\Models\Surat;
use App\Models\PengesahanSurat;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use SimpleSoftwareIO\QrCode\Facades\QrCode;



class SuratPengesahanService
{


    /**
     * Proses Pengesahan Surat
     */
    public function proses(
        Surat $surat,
        string $metode,
        $user
    )
    {


        /*
        |--------------------------------------------------------------------------
        | Normalisasi Metode
        |--------------------------------------------------------------------------
        */

        $metodeInput = strtolower($metode);



        $qrFile  = null;

        $ttdFile = null;



        /*
        |--------------------------------------------------------------------------
        | QR CODE
        |--------------------------------------------------------------------------
        */


        if(
            $metodeInput == 'qrcode'
            ||
            $metodeInput == 'qr code'
        )
        {


            $metodeDatabase = 'QR Code';



            $token =

            'TVRI-VERIFY-'
            .now()->format('YmdHis')
            .'-'
            .Str::upper(
                Str::random(6)
            );





            /*
            |--------------------------------------------------------------------------
            | Folder QR
            |--------------------------------------------------------------------------
            */


            $folder = 'surat/qr';



            if(
                !Storage::disk('public')
                ->exists($folder)
            )
            {

                Storage::disk('public')
                ->makeDirectory($folder);

            }





            /*
            |--------------------------------------------------------------------------
            | Generate File QR
            |--------------------------------------------------------------------------
            */


            $fileName =

            'qr-surat-'
            .$surat->id
            .'.svg';




            $qrFile =

            $folder
            .'/'
            .$fileName;





            Storage::disk('public')
            ->put(


                $qrFile,


                QrCode::format('svg')
                ->size(300)
                ->generate(

                    url(
                        '/verifikasi/'.$token
                    )

                )


            );



        }




        /*
        |--------------------------------------------------------------------------
        | TTE
        |--------------------------------------------------------------------------
        */


        elseif(
            $metodeInput == 'tte'
        )
        {


            $metodeDatabase = 'TTE';



            $token =

            'TTE-'
            .now()->format('YmdHis');



            /*
            |--------------------------------------------------------------------------
            | Nanti ambil file TTE pejabat
            |--------------------------------------------------------------------------
            */


            $ttdFile = null;



        }



        else
        {


            throw new \Exception(
                'Metode pengesahan tidak valid'
            );


        }





        /*
        |--------------------------------------------------------------------------
        | Simpan Data Pengesahan
        |--------------------------------------------------------------------------
        */


        PengesahanSurat::updateOrCreate(

            [

                'surat_id'=>$surat->id

            ],


            [

                'user_id'=>$user->id,


                'metode'=>$metodeDatabase,


                'status'=>'Disahkan',


                'nomor_verifikasi'=>$token,


                'qr_code'=>$qrFile,


                'ttd_file'=>$ttdFile,


                'tanggal_pengesahan'=>now()


            ]

        );







        /*
        |--------------------------------------------------------------------------
        | Update Status Surat
        |--------------------------------------------------------------------------
        */


        $surat->update([


            'status'=>'Disahkan',


            'tanggal_selesai'=>now()


        ]);






        return $surat;



    }


}