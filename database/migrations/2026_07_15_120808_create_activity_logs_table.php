<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('aktivitas',255);

            $table->string('modul',100);

            $table->string('method',20)->nullable();

            $table->string('url',255)->nullable();

            $table->ipAddress('ip_address')->nullable();

            $table->string('browser',255)->nullable();

            $table->string('device',255)->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};