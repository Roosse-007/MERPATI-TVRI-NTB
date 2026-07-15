<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prioritas_surat', function (Blueprint $table) {

            $table->id();

            $table->string('nama_prioritas',50)->unique();

            $table->integer('urutan');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prioritas_surat');
    }
};