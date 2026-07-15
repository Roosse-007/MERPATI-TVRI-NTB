<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposisi', function (Blueprint $table) {

            $table->id();

            $table->foreignId('surat_id')
                ->constrained('surat')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('dari_user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('ke_user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('instruksi');

            $table->boolean('dibaca')->default(false);

            $table->timestamp('dibaca_at')->nullable();

            $table->string('status',30)->default('Aktif');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};