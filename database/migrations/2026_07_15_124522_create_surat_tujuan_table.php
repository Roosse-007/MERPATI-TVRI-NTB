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
        Schema::create('surat_tujuan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->boolean('dibaca')->default(false);

            $table->timestamp('dibaca_at')->nullable();

            $table->timestamps();

            $table->unique(['surat_id','user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tujuan');
    }
};