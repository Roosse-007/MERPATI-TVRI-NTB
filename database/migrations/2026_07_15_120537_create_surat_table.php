<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | MASTER DATA
            |--------------------------------------------------------------------------
            */

            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sifat_surat_id')
                ->constrained('sifat_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('prioritas_surat_id')
                ->constrained('prioritas_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('template_surat_id')
                ->nullable()
                ->constrained('template_surat')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | PENGIRIM
            |--------------------------------------------------------------------------
            */

            $table->foreignId('pengirim_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INFORMASI SURAT
            |--------------------------------------------------------------------------
            */

            $table->string('nomor_surat', 100)->unique();

            $table->string('perihal', 255);

            $table->string('ringkasan', 255)->nullable();

            // isi_surat dihapus

            /*
            |--------------------------------------------------------------------------
            | TANGGAL
            |--------------------------------------------------------------------------
            */

            $table->date('tanggal_surat');

            $table->date('deadline')->nullable();

            $table->dateTime('tanggal_kirim')->nullable();

            $table->dateTime('tanggal_selesai')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->string('status', 40)->default('Draft');

            /*
            |--------------------------------------------------------------------------
            | CATATAN
            |--------------------------------------------------------------------------
            */

            $table->text('catatan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FILE SURAT
            |--------------------------------------------------------------------------
            */

            $table->string('file_surat', 255)->nullable();

            /*
            |--------------------------------------------------------------------------
            | ARSIP
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_archived')->default(false);

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMP
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};