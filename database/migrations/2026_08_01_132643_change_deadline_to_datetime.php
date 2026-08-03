<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::table('surat', function (Blueprint $table) {

            $table->dateTime('deadline')
                  ->nullable()
                  ->change();

        });



        Schema::table('disposisi', function (Blueprint $table) {

            $table->dateTime('deadline')
                  ->nullable()
                  ->change();

        });

    }



    public function down(): void
    {

        Schema::table('surat', function (Blueprint $table) {

            $table->date('deadline')
                  ->nullable()
                  ->change();

        });



        Schema::table('disposisi', function (Blueprint $table) {

            $table->date('deadline')
                  ->nullable()
                  ->change();

        });

    }

};