<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('approver_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedTinyInteger('urutan');

            $table->string('status',30)->default('Menunggu');

            $table->text('catatan')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval');
    }
};