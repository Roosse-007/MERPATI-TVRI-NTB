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
        Schema::create('jabatan', function (Blueprint $table) {

            $table->id();

            // Nama Jabatan
            $table->string('nama_jabatan', 150);

            // Level Jabatan
            $table->unsignedTinyInteger('level_jabatan')
                ->comment('1=Staff, 2=Kepala Program, 3=Kepala Tata Usaha, 4=Kepala Stasiun');

            // Keterangan
            $table->text('deskripsi')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};