<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        if (!Schema::hasColumn('nomor_surat', 'status')) {

            Schema::table('nomor_surat', function(Blueprint $table){

                $table->enum(
                    'status',
                    [
                        'Aktif',
                        'Nonaktif'
                    ]
                )
                ->default('Aktif')
                ->after('tahun');

            });

        }

    }



    public function down(): void
    {

        if (Schema::hasColumn('nomor_surat', 'status')) {

            Schema::table('nomor_surat', function(Blueprint $table){

                $table->dropColumn('status');

            });

        }

    }

};