<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropForeign(['prioritas_surat_id']);
            $table->dropColumn('prioritas_surat_id');
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->foreignId('prioritas_surat_id')
                  ->nullable()
                  ->constrained('prioritas_surat');
        });
    }
};