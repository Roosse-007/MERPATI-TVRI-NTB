<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('pengesahan_surat', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | RELASI SURAT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | PEJABAT PENGESAH
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | METODE PENGESAHAN
            |--------------------------------------------------------------------------
            */

            $table->enum('metode',[

                'TTE',
                'QR Code'

            ]);



            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status',[

                'Menunggu',
                'Disahkan',
                'Ditolak'

            ])
            ->default('Menunggu');



            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI
            |--------------------------------------------------------------------------
            */

            $table->string('nomor_verifikasi')
                ->unique();



            /*
            |--------------------------------------------------------------------------
            | FILE TANDA TANGAN
            |--------------------------------------------------------------------------
            */

            $table->string('ttd_file')
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | QR CODE
            |--------------------------------------------------------------------------
            */

            $table->string('qr_code')
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | WAKTU
            |--------------------------------------------------------------------------
            */

            $table->timestamp('tanggal_pengesahan')
                ->nullable();



            $table->text('catatan')
                ->nullable();



            $table->timestamps();


        });

    }



    public function down(): void
    {

        Schema::dropIfExists('pengesahan_surat');

    }

};