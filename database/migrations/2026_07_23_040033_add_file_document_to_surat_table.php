<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::table('surat', function (Blueprint $table) {


            $table->string('file_docx_path')
                ->nullable()
                ->after('file_surat');


            $table->string('file_pdf_path')
                ->nullable()
                ->after('file_docx_path');


        });

    }



    public function down(): void
    {

        Schema::table('surat', function (Blueprint $table) {


            $table->dropColumn([
                'file_docx_path',
                'file_pdf_path'
            ]);


        });

    }

};