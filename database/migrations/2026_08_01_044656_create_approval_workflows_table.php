<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_workflows', function (Blueprint $table) {

            $table->id();

            // Jenis surat yang menggunakan workflow ini
            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surat')
                ->cascadeOnDelete();

            // Jabatan yang melakukan approval
            $table->foreignId('jabatan_id')
                ->constrained('jabatan')
                ->cascadeOnDelete();

            // Urutan approval
            $table->unsignedInteger('urutan');

            // Aktif / Nonaktif
            $table->boolean('aktif')->default(true);

            $table->timestamps();

            $table->unique([
                'jenis_surat_id',
                'urutan'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_workflows');
    }
};