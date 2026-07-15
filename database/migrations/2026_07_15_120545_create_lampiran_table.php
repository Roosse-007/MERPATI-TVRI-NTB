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
        Schema::create('lampiran', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nama_file',255);

            $table->string('path_file',255);

            $table->string('mime_type',100);

            $table->bigInteger('ukuran_file')->nullable();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran');
    }
};