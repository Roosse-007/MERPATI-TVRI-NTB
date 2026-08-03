<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {

            if (Schema::hasColumn('surat', 'isi_surat')) {

                $table->dropColumn('isi_surat');

            }

        });
    }


    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {

            $table->longText('isi_surat');

        });
    }
};