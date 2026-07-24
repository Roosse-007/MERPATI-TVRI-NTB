<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('nomor_surat', function (Blueprint $table) {


            $table->id();


            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();



            // contoh:
            // 001/TVRI/NTB/VII/{tahun}

            $table->string('kode_nomor',50);



            // nomor terakhir dipakai

            $table->integer('nomor_terakhir')
                ->default(0);



            $table->year('tahun');



            $table->enum('status',[

                'Aktif',
                'Tidak Aktif'

            ])
            ->default('Aktif');



            $table->timestamps();


        });
    }



    public function down(): void
    {
        Schema::dropIfExists('nomor_surat');
    }

};