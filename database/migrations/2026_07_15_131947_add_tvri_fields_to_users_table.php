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
        Schema::table('users', function (Blueprint $table) {

            // Relasi Unit Kerja
            $table->foreignId('unit_kerja_id')
                ->nullable()
                ->after('id')
                ->constrained('unit_kerja')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Relasi Jabatan
            $table->foreignId('jabatan_id')
                ->nullable()
                ->after('unit_kerja_id')
                ->constrained('jabatan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Data Pegawai
            $table->string('nip', 30)
                ->unique()
                ->after('jabatan_id');

            $table->string('username', 50)
                ->unique()
                ->after('nip');

            // Profil
            $table->string('foto', 255)
                ->nullable()
                ->after('password');

            $table->string('nomor_hp', 20)
                ->nullable()
                ->after('foto');

            $table->text('alamat')
                ->nullable()
                ->after('nomor_hp');

            // File TTE
            $table->string('tte_file', 255)
                ->nullable()
                ->after('alamat');

            // Status User
            $table->boolean('is_active')
                ->default(true)
                ->after('tte_file');

            // Login Terakhir
            $table->timestamp('last_login')
                ->nullable()
                ->after('is_active');

            // Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['unit_kerja_id']);
            $table->dropForeign(['jabatan_id']);

            $table->dropColumn([
                'unit_kerja_id',
                'jabatan_id',
                'nip',
                'username',
                'foto',
                'nomor_hp',
                'alamat',
                'tte_file',
                'is_active',
                'last_login',
                'deleted_at',
            ]);
        });
    }
};