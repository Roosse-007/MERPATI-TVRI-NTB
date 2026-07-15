<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_tim', function (Blueprint $table) {

            $table->id();

            $table->foreignId('unit_kerja_id')
                ->constrained('unit_kerja')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedTinyInteger('bulan');

            $table->year('tahun');

            $table->integer('target');

            $table->integer('realisasi')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_tim');
    }
};