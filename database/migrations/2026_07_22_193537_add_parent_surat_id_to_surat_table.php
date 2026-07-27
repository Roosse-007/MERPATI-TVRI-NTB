<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::table('surat', function (Blueprint $table) {


            $table->foreignId('parent_surat_id')
                ->nullable()
                ->after('id')
                ->constrained('surat')
                ->nullOnDelete();


        });


    }



    public function down(): void
    {

        Schema::table('surat', function (Blueprint $table) {


            $table->dropForeign([
                'parent_surat_id'
            ]);


            $table->dropColumn(
                'parent_surat_id'
            );


        });

    }


};