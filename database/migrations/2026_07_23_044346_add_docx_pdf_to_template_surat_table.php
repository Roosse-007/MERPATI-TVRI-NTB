<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('template_surat', function (Blueprint $table) {


            /*
            |--------------------------------------------------------------------------
            | TEMPLATE WORD
            |--------------------------------------------------------------------------
            |
            | Digunakan PhpWord untuk memasukkan TTE / QR Code
            |
            */

            $table->string('file_docx')
                ->nullable()
                ->after('nama_template');



            /*
            |--------------------------------------------------------------------------
            | TEMPLATE PDF
            |--------------------------------------------------------------------------
            |
            | Untuk preview / arsip
            |
            */

            $table->string('file_pdf')
                ->nullable()
                ->after('file_docx');


        });

    }



    public function down(): void
    {

        Schema::table('template_surat', function (Blueprint $table) {


            $table->dropColumn([
                'file_docx',
                'file_pdf'
            ]);


        });

    }

};