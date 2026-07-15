<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('folder_nas',255);

            $table->string('lokasi_file',255);

            $table->foreignId('diarsipkan_oleh')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamp('tanggal_arsip');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};